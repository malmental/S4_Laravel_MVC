{{--
    Componente: stat-card
    Descripción: Tarjeta de estadísticas para el dashboard.
                  Muestra un título, unteo), y un enlace.
 número grande (con    
    Props:
        - title: Título de la tarjeta (ej: "Críticas", "Abiertas")
        - count: Número a mostrar (ej: 5, 12, 0)
        - href: Enlace al hacer click (default: '#')
        - active: Boolean - si es true, aplica estilo invertido (fondo negro, texto blanco)
        - variant: 'default' o 'critical' - cambia el comportamiento de active
        - $slot: Texto inferior (ej: "Incidencias de alta prioridad")
    
    Uso:
        <x-stat-card 
            title="Críticas" 
            :count="5" 
            href="/dashboard?prioridad=alta"
            :active="true"
            variant="critical"
        >
            Incidencias de alta prioridad
        </x-stat-card>
--}}

@props([
    'title',
    'count',
    'href' => '#',
    'active' => false,
    'variant' => 'default'
])

@php
    // Clases base: tarjeta con borde, padding, centro y hover
    $baseClasses = 'block border-2 border-black p-6 text-center hover:bg-cream-dark interactive-card';
    
    // Clases para estado activo (cuando el filtro está seleccionado)
    $activeClasses = $active ? 'bg-black text-white' : 'bg-white';
    
    // Variante critical: comportamiento especial de inversión de colores
    $variantClasses = $variant === 'critical' ? ($active ? 'bg-black text-white' : 'bg-white') : '';
@endphp

{{-- Tarjeta como enlace --}}
<a href="{{ $href }}" class="{{ $baseClasses }} {{ $variant === 'critical' ? $variantClasses : $activeClasses }}">
    
    {{-- Título superior en mayúsculas --}}
    <div class="text-xs uppercase tracking-wide mb-3">{{ $title }}</div>
    
    {{-- Número grande centrado (ej: 05, 12) --}}
    <div class="text-5xl font-light mb-2">{{ str_pad($count ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
    
    {{-- Slot para texto inferior (descripción) --}}
    <div class="text-xs">
        {{ $slot }}
    </div>
</a>
