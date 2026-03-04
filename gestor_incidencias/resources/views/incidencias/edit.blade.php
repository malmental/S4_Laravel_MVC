@extends('layouts.app')
@section('title', 'Editar Incidencia')

@section('content')
{{-- Tarjeta principal de edición de incidencia --}}
<div class="bg-white max-w-3xl mx-auto">
    
    {{-- Cabecera del formulario --}}
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Editar Incidencia</h2>
    </div>

    {{-- Formulario de actualización (PUT) --}}
    <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        {{-- Campo: título --}}
        <div>
            <label class="block text-xs uppercase mb-2">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $incidencia->titulo) }}" required class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
            @error('titulo') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Campo: descripción --}}
        <div>
            <label class="block text-xs uppercase mb-2">Descripción</label>
            <textarea name="descripcion" rows="5" required class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
            @error('descripcion') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Campo: tags (separados por espacios) --}}
        <div>
            <label class="block text-xs uppercase mb-2">Tags</label>
            <input
                type="text"
                name="tags"
                value="{{ old('tags', $incidencia->tags->pluck('nombre')->implode(' ')) }}"
                placeholder="backend urgente bug"
                class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none"
            >
            <p class="text-xs text-gray-500 mt-1">Separa con espacios.</p>
            @error('tags') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Campos agrupados: estado y prioridad --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase mb-2">Estado</label>
                <select name="estado" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                    <option value="abierta" {{ old('estado', $incidencia->estado) === 'abierta' ? 'selected' : '' }}>Abierta</option>
                    <option value="en_proceso" {{ old('estado', $incidencia->estado) === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="cerrada" {{ old('estado', $incidencia->estado) === 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                </select>
                @error('estado') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs uppercase mb-2">Prioridad</label>
                <select name="prioridad" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                    <option value="baja" {{ old('prioridad', $incidencia->prioridad) === 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="media" {{ old('prioridad', $incidencia->prioridad) === 'media' ? 'selected' : '' }}>Media</option>
                    <option value="alta" {{ old('prioridad', $incidencia->prioridad) === 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
                @error('prioridad') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Acciones finales: guardar o volver --}}
        <div class="pt-2 flex gap-2">
            <button type="submit" class="px-5 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                Actualizar incidencia
            </button>
            <a href="{{ route('incidencias.index') }}" data-soft-nav="1" class="px-5 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection