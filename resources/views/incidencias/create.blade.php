@extends('layouts.app')
@section('title', 'Nueva Incidencia')
@section('content')
<div class="border-3 border-black bg-white max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Nueva Incidencia</h2>
    </div>
    <form action="{{ route('incidencias.store') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <!-- Titulo -->
        <div>
            <label class="block text-sm uppercase mb-1">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo') }}" required class="w-full px-4 py-2 border-2 border-black bg-cream focus:bg-white focus:outline-none">
            @error('titulo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Descripción -->
        <div>
            <label class="block text-sm uppercase mb-1">Descripción</label>
            <textarea name="descripcion" required rows="4" class="w-full px-4 py-2 border-2 border-black bg-cream focus:bg-white focus:outline-none">{{ old('descripcion') }}</textarea>
            @error('descripcion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- TAGS -->
        <div class="mt-6">
            <label class="block text-sm tracking-widest">TAGS</label>
            <input type="text" name="tags" placeholder="bug, backend, urgent" class="w-full border-2 border-black p-2 bg-neutral-200 focus:outline-none">

            <p class="text-xs mt-2">
                Separate tags with spaces
            </p>
        </div>

        <!-- ESTADO -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm uppercase mb-1">Estado</label>
                <select name="estado" class="w-full px-4 py-2 border-2 border-black bg-cream focus:outline-none">
                    <option value="abierta">Abierta</option>
                    <option value="en_proceso">En proceso</option>
                    <option value="cerrada">Cerrada</option>
                </select>
            </div>

        <!-- PRIORIDAD -->
        <div>
            <label class="block text-sm uppercase mb-1">Prioridad</label>
            <select name="prioridad" class="w-full px-4 py-2 border-2 border-black bg-cream focus:outline-none">
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>
            
        <div class="flex gap-4 pt-4">
            <button type="submit" class="px-6 py-2 border-2 border-black bg-black text-white text-xs uppercase hover:bg-gray-800">
                Crear
            </button>
            <a href="{{ route('incidencias.index') }}" class="px-6 py-2 border-2 border-black bg-white text-xs uppercase hover:bg-cream-dark">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection