{{--
    Componente: incidence-detail
    Descripción: Bloque visual que muestra todos los detalles de una incidencia.
                  Se usa en la vista de detalle (show) y en el modal de "ver" del index.
    
    Props:
        - incidencia: Instancia del modelo Incidencia (requerido)
    
    Uso:
        <x-domain-incidence-detail :incidencia="$incidencia" />
--}}

@props(['incidencia'])

{{-- Contenedor principal con espacios verticales entre secciones --}}
<div class="space-y-4">
    
    {{-- Sección: Título --}}
    <div>
        <p class="text-xs uppercase text-gray-500 mb-1">Título</p>
        <p class="font-medium">{{ $incidencia->titulo }}</p>
    </div>
    
    {{-- Sección: Descripción (en caja con fondo cream) --}}
    <div>
        <p class="text-xs uppercase text-gray-500 mb-1">Descripción</p>
        <div class="p-4 border border-gray-300 bg-cream text-sm">
            {{ $incidencia->descripcion }}
        </div>
    </div>

    {{-- Sección: Prioridad y Estado (en línea) --}}
    <div class="flex gap-4">
        {{-- Badge de Prioridad (negro si es alta) --}}
        <div>
            <p class="text-xs uppercase text-gray-500 mb-1">Prioridad</p>
            <span class="px-2 py-1 border-2 border-black text-xs uppercase {{ $incidencia->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }}">
                {{ $incidencia->prioridad }}
            </span>
        </div>
        {{-- Badge de Estado --}}
        <div>
            <p class="text-xs uppercase text-gray-500 mb-1">Estado</p>
            <span class="px-2 py-1 border-2 border-black text-xs uppercase bg-white">
                {{ $incidencia->estado }}
            </span>
        </div>
    </div>

    {{-- Sección: Etiquetas (tags) - permite múltiples --}}
    <div>
        <p class="text-xs uppercase text-gray-500 mb-1">Etiquetas</p>
        <div class="flex flex-wrap gap-1">
            @forelse($incidencia->tags as $tag)
                <span class="px-2 py-1 text-xs bg-gray-300/50 text-gray-700 rounded">#{{ $tag->nombre }}</span>
            @empty
                {{-- Mensaje cuando no hay etiquetas --}}
                <span class="text-xs text-gray-400">—</span>
            @endforelse
        </div>
    </div>

    {{-- Sección: Fecha de creación --}}
    <div>
        <p class="text-xs uppercase text-gray-500 mb-1">Creada</p>
        <p class="text-sm">{{ $incidencia->created_at->format('Y-m-d H:i') }}</p>
    </div>
</div>
