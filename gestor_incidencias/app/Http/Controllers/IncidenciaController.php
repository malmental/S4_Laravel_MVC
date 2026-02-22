<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use Illuminate\Support\Facades\Auth;
class IncidenciaController extends Controller
{
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
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:abierta,en_proceso,cerrada',
            'prioridad' => 'required|in:baja,media,alta',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        Incidencia::create($validated);
        
        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada correctamente');
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
        
        return view('incidencias.edit', compact('incidencia'));
    }
    
    public function update(Request $request, Incidencia $incidencia)
    {
        if ($incidencia->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:abierta,en_proceso,cerrada',
            'prioridad' => 'required|in:baja,media,alta',
        ]);
        
        $incidencia->update($validated);
        
        return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada correctamente');
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
        $query = Incidencia::query()->with('user', 'comments.user', 'comments.replies', 'comments.replies.user');
    
        // Filtros acumulativos
        $prioridades = $request->input('prioridad', []);
        $estados = $request->input('estado', []);
    
        if (!empty($prioridades)) {
            $query->whereIn('prioridad', $prioridades);
        }
    
        if (!empty($estados)) {
            $query->whereIn('estado', $estados);
        }
    
        $incidencias = $query->orderBy('created_at', 'desc')->get();
    
        // Stats sobre el TOTAL de TODAS las incidencias
        $altaPrioridad = Incidencia::where('prioridad', 'alta')->count();
        $abiertas = Incidencia::where('estado', 'abierta')->count();
        $enProceso = Incidencia::where('estado', 'en_proceso')->count();
        $cerradas = Incidencia::where('estado', 'cerrada')->count();
    
        // Calcular URLs de filtros
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