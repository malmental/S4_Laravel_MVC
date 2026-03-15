{{--
    Componente: incidence-form
    Descripción: Formulario unificado para crear o editar incidencias.
    
    Props:
        - method: Método HTTP (POST, PUT, PATCH). Default: POST
        - action: Ruta destino del formulario. Default: '#'
        - incidencia: Instancia del modelo Incidencia (opcional, para edición)
        - submitText: Texto del botón submit. Default: 'Guardar'
        - $actions: Slot para botones adicionales (cancelar, etc.)
    
    Uso:
        {{-- Crear nueva incidencia --}}
        <x-incidence-form action="/incidencias" submitText="Crear">
            <button>Cancelar</button>
        </x-incidence-form>
        
        {{-- Editar incidencia existente --}}
        <x-incidence-form method="PUT" action="/incidencias/1" :incidencia="$incidencia" submitText="Actualizar">
            <button>Cancelar</button>
        </x-incidence-form>
--}}

@props([
    'method' => 'POST',
    'action' => '#',
    'incidencia' => null,
    'submitText' => 'Guardar'
])

@php
    // Si hay incidencia, obtener tags como string separadas por espacios
    // Si no, usar old() para mantener valor tras error de validación
    $tagsValue = $incidencia ? $incidencia->tags->pluck('nombre')->implode(' ') : old('tags', '');
@endphp

{{-- Formulario con espacios verticales entre campos --}}
<form action="{{ $action }}" method="POST" class="space-y-5">
    @csrf
    {{-- Si el método no es POST, agregar token de método (PUT, DELETE, etc.) --}}
    @if($method !== 'POST')
        @method($method)
    @endif

    {{-- Campo: Título --}}
    <div>
        <label class="block text-xs uppercase mb-2">Título</label>
        <input 
            type="text" 
            name="titulo" 
            value="{{ old('titulo', $incidencia?->titulo) }}" 
            required 
            class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none"
        >
        @error('titulo') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Campo: Descripción --}}
    <div>
        <label class="block text-xs uppercase mb-2">Descripción</label>
        <textarea 
            name="descripcion" 
            rows="5" 
            required 
            class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none"
        >{{ old('descripcion', $incidencia?->descripcion) }}</textarea>
        @error('descripcion') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Campo: Etiquetas (tags) --}}
    <div>
        <label class="block text-xs uppercase mb-2">Etiquetas</label>
        <input 
            type="text" 
            name="tags" 
            value="{{ $tagsValue }}" 
            placeholder="backend urgente bug" 
            class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none"
        >
        <p class="text-xs text-gray-500 mt-1">Separa con espacios.</p>
        @error('tags') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Campos combinados: Estado y Prioridad (2 columnas en desktop) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Selector de Estado --}}
        <div>
            <label class="block text-xs uppercase mb-2">Estado</label>
            <select name="estado" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                <option value="abierta" {{ old('estado', $incidencia?->estado ?? 'abierta') === 'abierta' ? 'selected' : '' }}>Abierta</option>
                <option value="en_proceso" {{ old('estado', $incidencia?->estado) === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="cerrada" {{ old('estado', $incidencia?->estado) === 'cerrada' ? 'selected' : '' }}>Cerrada</option>
            </select>
            @error('estado') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Selector de Prioridad --}}
        <div>
            <label class="block text-xs uppercase mb-2">Prioridad</label>
            <select name="prioridad" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                <option value="baja" {{ old('prioridad', $incidencia?->prioridad ?? 'media') === 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('prioridad', $incidencia?->prioridad ?? 'media') === 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('prioridad', $incidencia?->prioridad) === 'alta' ? 'selected' : '' }}>Alta</option>
            </select>
            @error('prioridad') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Slot para botones de acción (cancelar, submit, etc.) --}}
    <div class="pt-2 flex gap-2 justify-end">
        {{ $actions ?? null }}
    </div>
</form>
