<?php

namespace App\Services;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaService
{
    /**
     * Obtener metricas con estadisticas
     */
    public function getMetricas(Request $request): array
    {
        // 1. Construir query con filtros
        $query = $this->buildFilteredQuery($request);
        
        // 2. Obtener incidencias paginadas
        $incidencias = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // 3. Calcular estadísticas
        $estadisticas = $this->getEstadisticas();
        
        // 4. Construir URLs de filtros
        $filterUrls = $this->buildFilterUrls($request);
        
        return [
            'incidencias' => $incidencias,
            'abiertas' => $estadisticas['abierta'] ?? 0,
            'enProceso' => $estadisticas['en_proceso'] ?? 0,
            'cerradas' => $estadisticas['cerrada'] ?? 0,
            'altaPrioridad' => $estadisticas['alta'] ?? 0,
            'prioridades' => $request->input('prioridad', []),
            'estados' => $request->input('estado', []),
            'filterUrls' => $filterUrls,
        ];
    }

     /**
     * Construir query con filtros
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = Incidencia::query()->with([
            'user',
            'tags',
            'comments.user',
            'comments.replies',
            'comments.replies.user'
        ]);
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
        return $query;
    }

    /**
     * Obtener estadísticas globales
     */
    private function getEstadisticas(): array
    {
        // Estado: 1 consulta con groupBy
        $porEstado = Incidencia::select('estado')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();
        // Prioridad alta: 1 consulta
        $altaPrioridad = Incidencia::where('prioridad', 'alta')->count();
        return [
            'abierta' => $porEstado['abierta'] ?? 0,
            'en_proceso' => $porEstado['en_proceso'] ?? 0,
            'cerrada' => $porEstado['cerrada'] ?? 0,
            'alta' => $altaPrioridad,
        ];
    }

    /**
     * Construir URLs para filtros
     */
    private function buildFilterUrls(Request $request): array
    {
        $prioridades = $request->input('prioridad', []);
        $estados = $request->input('estado', []);
        return [
            'critical' => $this->buildFilterUrl('prioridad', 'alta', $prioridades),
            'open' => $this->buildFilterUrl('estado', 'abierta', $estados),
            'inProgress' => $this->buildFilterUrl('estado', 'en_proceso', $estados),
            'closed' => $this->buildFilterUrl('estado', 'cerrada', $estados),
        ];
    }

    /**
     * Construir URL para un filtro específico
     */
    private function buildFilterUrl(string $type, string $value, array $currentFilters): string
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