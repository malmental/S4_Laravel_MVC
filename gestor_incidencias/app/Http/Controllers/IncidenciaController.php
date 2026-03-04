<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasTags;
use App\Http\Requests\IncidenciaStoreRequest;
use App\Http\Requests\IncidenciaUpdateRequest;
use App\Models\Incidencia;
use App\Services\IncidenciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    use HasTags;

    public function __construct(
        private IncidenciaService $incidenciaService
    ) {}

    public function index()
    {
        $incidencias = Auth::user()
            ->incidencias()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('incidencias.index', compact('incidencias'));
    }

    public function create()
    {
        return view('incidencias.create');
    }

    public function store(IncidenciaStoreRequest $request)
    {
        $incidencia = DB::transaction(function () use ($request) {
            $incidencia = Incidencia::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'prioridad' => $request->prioridad,
                'estado' => $request->estado,
                'user_id' => Auth::id(),
            ]);

            $this->syncTags($incidencia, $request->tags);

            return $incidencia;
        });

        return redirect()->route('incidencias.index')
            ->with('success', 'Incidencia creada correctamente');
    }

    public function show(Incidencia $incidencia)
    {
        $this->authorize('view', $incidencia);

        return view('incidencias.show', compact('incidencia'));
    }

    public function edit(Incidencia $incidencia)
    {
        $this->authorize('update', $incidencia);

        $incidencia->load('tags');

        return view('incidencias.edit', compact('incidencia'));
    }

    public function update(IncidenciaUpdateRequest $request, Incidencia $incidencia)
    {
        $this->authorize('update', $incidencia);

        DB::transaction(function () use ($request, $incidencia) {
            $incidencia->update($request->validated());
            $this->syncTags($incidencia, $request->tags);
        });

        return redirect()
            ->route('incidencias.index')
            ->with('success', 'Incidencia actualizada correctamente');
    }

    public function destroy(Incidencia $incidencia)
    {
        $this->authorize('delete', $incidencia);

        $incidencia->delete();

        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada correctamente');
    }

    public function metricas(Request $request)
    {
        $this->authorize('viewAny', Incidencia::class);
        $data = $this->incidenciaService->getMetricas($request);

        return view('dashboard', $data);
    }
}
