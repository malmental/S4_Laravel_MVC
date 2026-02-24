<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->incidencias()
            ->with('tags')
            ->orderBy('created_at', 'desc');

        // Filtro por tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
            $q->where('nombre', str_replace('#', '', $request->tag));
            });
        }

        $incidencias = $query->get();

        $comentarios = Comment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $estadisticas = [
            'abiertas' => $incidencias->where('estado', 'abierta')->count(),
            'en_proceso' => $incidencias->where('estado', 'en_proceso')->count(),
            'cerradas' => $incidencias->where('estado', 'cerrada')->count(),
        ];
        
        return view('dashboard', compact('incidencias', 'comentarios', 'estadisticas'));
    }

    public function metricas()
    {
        $user = Auth::user();
        $incidencias = $user->incidencias()->get();

        return view('metrics', compact('incidencias'));
    }
}