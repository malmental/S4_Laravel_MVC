@extends('layouts.app')
@section('title', 'Editar Incidencia')
@section('content')
<div class="border-3 border-black bg-white max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Editar Incidencia</h2>
    </div>
    <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST" class="p-6 space-y-4">
        @csrf @method('PUT')
        
        <div>
            <label class="block text-xs uppercase mb-1">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $incidencia->titulo) }}" required class="w-full px-4 py-2 border-2 border-black bg-cream focus:bg-white focus:outline-none">
            @error('titulo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs uppercase mb-1">Descripción</label>
            <textarea name="descripcion" required rows="4" class="w-full px-4 py-2 border-2 border-black bg-cream focus:bg-white focus:outline-none">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
            @error('descripcion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-xs uppercase mb-2">Tags</label>
            <input 
            type="text" name="tags" value="{{ $incidencia->tags->pluck('nombre')->implode(', ') }}" class="w-full border-2 border-black px-4 py-2 text-sm">
            <p class="text-xs mt-2 text-gray-500">
                Separate tags with spaces
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase mb-1">Estado</label>
                <select name="estado" class="w-full px-4 py-2 border-2 border-black bg-cream focus:outline-none">
                    <option value="abierta" {{ old('estado', $incidencia->estado)=='abierta' ? 'selected' : '' }}>Abierta</option>
                    <option value="en_proceso" {{ old('estado', $incidencia->estado)=='en_proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="cerrada" {{ old('estado', $incidencia->estado)=='cerrada' ? 'selected' : '' }}>Cerrada</option>
                </select>
            </div>

            <div>
                <label class="block text-xs uppercase mb-1">Prioridad</label>
                <select name="prioridad" class="w-full px-4 py-2 border-2 border-black bg-cream focus:outline-none">
                    <option value="baja" {{ old('prioridad', $incidencia->prioridad)=='baja' ? 'selected' : '' }}>Baja</option>
                    <option value="media" {{ old('prioridad', $incidencia->prioridad)=='media' ? 'selected' : '' }}>Media</option>
                    <option value="alta" {{ old('prioridad', $incidencia->prioridad)=='alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="px-6 py-2 border-2 border-black bg-black text-white text-xs uppercase hover:bg-gray-800">Actualizar</button>
            <a href="{{ route('incidencias.index') }}" class="px-6 py-2 border-2 border-black bg-white text-xs uppercase hover:bg-cream-dark">Cancelar</a>
        </div>
    </form>
</div>
@endsection