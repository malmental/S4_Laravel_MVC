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

    public function metricas()
    {
        $user = auth()->user();

        $total = $user->incidencias()->count();
        $abiertas = $user->incidencias()->where('estado', 'abierta')->count();
        $enProceso = $user->incidencias()->where('estado', 'en_proceso')->count();
        $cerradas = $user->incidencias()->where('estado', 'cerrada')->count();
        $altaPrioridad = $user->incidencias()->where('prioridad', 'alta')->count();

        return view('dashboard', compact(
            'total',
            'abiertas',
            'enProceso',
            'cerradas',
            'altaPrioridad'
        ));
    }
}
