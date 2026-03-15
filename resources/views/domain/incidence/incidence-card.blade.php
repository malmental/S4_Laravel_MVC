{{--
    Componente: incidence-card
    Descripción: Fila individual para mostrar una incidencia en listas/tablas.
    
    Props:
        - incidencia: Instancia del modelo Incidencia (requerido)
        - clickable: Boolean para hacer la fila clickeable (opcional, default: false)
        - $actions: Slot para botones de acción (editar, eliminar, etc.)
    
    Uso:
        <x-incidence-card :incidencia="$incidencia">
            <button>Editar</button>
        </x-incidence-card>
--}}

@props(['incidencia', 'clickable' => false])

@php
    // Determina si la fila es clickeable y aplica estilos de hover
    $clickClass = $clickable ? 'cursor-pointer hover:bg-cream-dark transition-colors duration-150' : '';
@endphp

{{-- Contenedor principal: grid de 12 columnas para alineación responsive --}}
<div 
    class="grid grid-cols-12 gap-4 px-6 py-4 items-center border-b border-gray-300 {{ $clickClass }}"
>
    {{-- Columna 1: ID formateado (ej: INC-001) --}}
    <div class="col-span-12 md:col-span-1 font-semibold">
        INC-{{ str_pad($incidencia->id, 3, '0', STR_PAD_LEFT) }}
    </div>

    {{-- Columna 2-4: Título y descripción truncada --}}
    <div class="col-span-12 md:col-span-4">
        <div class="font-medium">{{ $incidencia->titulo }}</div>
        <div class="text-xs text-gray-500">{{ Str::limit($incidencia->descripcion, 70) }}</div>
    </div>

    {{-- Columna 5-6: Badge de prioridad (negro si es alta, blanco si no) --}}
    <div class="col-span-6 md:col-span-2">
        <span class="px-2 py-1 border-2 border-black text-xs uppercase {{ $incidencia->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }}">
            {{ $incidencia->prioridad }}
        </span>
    </div>

    {{-- Columna 7-8: Badge de estado --}}
    <div class="col-span-6 md:col-span-2">
        <span class="px-2 py-1 border-2 border-black text-xs uppercase bg-white">
            {{ $incidencia->estado }}
        </span>
    </div>

    {{-- Columna 9-12: Slot para botones de acción (editar, eliminar) --}}
    <div class="col-span-12 md:col-span-3 flex gap-2 md:justify-end">
        {{ $actions ?? '' }}
    </div>
</div>
