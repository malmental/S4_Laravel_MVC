@extends('layouts.app')
@section('title', 'Ver Incidencia')
@section('content')
<div class="border-3 border-black bg-white max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Detalle de Incidencia</h2>
        <span class="text-xs font-mono">INC-{{ str_pad($incidencia->id, 3, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="p-6 space-y-4">
        <div>
            <label class="block text-xs uppercase text-gray-500 mb-1">Título</label>
            <div class="text-lg font-medium">{{ $incidencia->titulo }}</div>
        </div>

        <div>
            <label class="block text-xs uppercase text-gray-500 mb-1">Descripción</label>
            <div class="p-4 bg-cream border border-gray-300">{{ $incidencia->descripcion }}</div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase text-gray-500 mb-1">Estado</label>
                <span class="px-3 py-1 border-2 border-black bg-white text-xs uppercase">{{ $incidencia->estado }}</span>
            </div>
            <div>
                <label class="block text-xs uppercase text-gray-500 mb-1">Prioridad</label>
                <span class="px-3 py-1 border-2 border-black {{ $incidencia->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }} text-xs uppercase">{{ $incidencia->prioridad }}</span>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-300">
            <label class="block text-xs uppercase text-gray-500 mb-1">Creada</label>
            <div class="text-sm">{{ $incidencia->created_at->format('Y-m-d H:i') }}</div>
        </div>
        
    </div>
    <div class="px-6 py-4 border-t-2 border-black bg-cream-dark flex gap-4">
        <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase hover:bg-gray-800">Editar</a>
        <a href="{{ route('incidencias.index') }}" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase hover:bg-cream-dark">← Volver</a>
    </div>
</div>
@endsection