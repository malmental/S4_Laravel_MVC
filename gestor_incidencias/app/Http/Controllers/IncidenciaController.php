<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\HasTags;
use App\Http\Requests\IncidenciaStoreRequest;
use App\Http\Requests\IncidenciaUpdateRequest;

class IncidenciaController extends Controller
{
    use HasTags;

    public function index()
    {
        $user = Auth::user(); 
        if (!$user) {
            abort(403, "No estás logueado");
        }
        
        $incidencias = $user->incidencias()->orderBy('created_at', 'desc')->get();
        
        return view('incidencias.index', compact('incidencias'));
    }
    
    public function create()
    {
        return view('incidencias.create');
    }
    
    public function store(IncidenciaStoreRequest $request)
    {
        $incidencia = Incidencia::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'estado' => $request->estado,
            'user_id' => Auth::id(),
        ]);
        $this->syncTags($incidencia, $request->tags);
        return redirect()->route('incidencias.index');
    }
    
    public function show(Incidencia $incidencia)
    {
        $this->authorize('update', $incidencia);
        
        return view('incidencias.show', compact('incidencia'));
    }
    
    public function edit(Incidencia $incidencia)
    {
        if ($incidencia->user_id !== Auth::id()) {
            abort(403);
        }
        $incidencia->load('tags');
        return view('incidencias.edit', compact('incidencia'));
    }
    
    public function update(IncidenciaUpdateRequest $request, Incidencia $incidencia)
    {
        if ($incidencia->user_id !== Auth::id()) {
            abort(403);
        }
        $incidencia->update($request->validated());
        $this->syncTags($incidencia, $request->tags);
        return redirect()
            ->route('incidencias.index')
            ->with('success', 'Incidencia actualizada correctamente');
    }
    
    public function destroy(Incidencia $incidencia)
    {
        if ($incidencia->user_id !== Auth::id()) {
            abort(403);
        }
        
        $incidencia->delete();
        
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada correctamente');
    }
    
    public function metricas(Request $request)
    {
        $user = auth()->user();
        $query = Incidencia::query()->with('user', 'tags', 'comments.user', 'comments.replies', 'comments.replies.user');
    
        $prioridades = $request->input('prioridad', []);
        $estados = $request->input('estado', []);
    
        if (!empty($prioridades)) {
            $query->whereIn('prioridad', $prioridades);
        }
    
        if (!empty($estados)) {
            $query->whereIn('estado', $estados);
        }
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('nombre', str_replace('#', '', $request->tag));
            });
        }       
    
        $incidencias = $query->orderBy('created_at', 'desc')->get();
    
        $altaPrioridad = Incidencia::where('prioridad', 'alta')->count();
        $abiertas = Incidencia::where('estado', 'abierta')->count();
        $enProceso = Incidencia::where('estado', 'en_proceso')->count();
        $cerradas = Incidencia::where('estado', 'cerrada')->count();
        $filterUrls = [
            'critical' => $this->buildFilterUrl('prioridad', 'alta', $prioridades),
            'open' => $this->buildFilterUrl('estado', 'abierta', $estados),
            'inProgress' => $this->buildFilterUrl('estado', 'en_proceso', $estados),
            'closed' => $this->buildFilterUrl('estado', 'cerrada', $estados),
        ];
    
        return view('dashboard', compact(
            'incidencias',
            'abiertas',
            'enProceso',
            'cerradas',
            'altaPrioridad',
            'prioridades',
            'estados',
            'filterUrls'
        ));
    }
    
    private function buildFilterUrl($type, $value, $currentFilters)
    {
        $arr = $currentFilters;
        
        if (in_array($value, $arr)) {
            $arr = array_filter($arr, fn($v) => $v !== $value);
        } else {
            $arr[] = $value;
        }
    
        $params = request()->except($type);
        
        if (!empty($arr)) {
            $params[$type] = $arr;
        }
    
        return route('dashboard', $params);
    }
}