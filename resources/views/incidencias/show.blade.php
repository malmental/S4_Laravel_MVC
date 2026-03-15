@extends('layouts.app')
@section('title', 'Detalle Incidencia')

@section('content')
{{-- Contenedor de detalle de una incidencia --}}
<div x-data="incidenciaShow()" class="motion-fade-in bg-white max-w-3xl mx-auto">
    
    {{-- Cabecera del detalle con ID formateado --}}
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Detalle de Incidencia</h2>
        <span class="text-xs font-mono">INC-{{ str_pad($incidencia->id, 3, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- Cuerpo informativo: campos, etiquetas y metadatos --}}
    <div class="p-6 space-y-5">
        <x-domain-incidence-detail :incidencia="$incidencia" />
    </div>

    {{-- Barra de acciones: editar, volver y eliminar --}}
    <div class="px-6 py-4 border-t-2 border-black bg-cream-dark flex flex-wrap items-center gap-2">
        <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
            Editar
        </a>
        <a href="{{ route('incidencias.index') }}" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
            Volver
        </a>
        <button type="button" @click="openDeleteModal()" class="px-4 py-2 border-2 border-red-700 bg-red-700 text-white text-xs uppercase interactive-btn ml-auto">
            Eliminar
        </button>
    </div>

    {{-- Modal de confirmación para eliminación --}}
    <div
        x-cloak
        x-show="deleteOpen"
        x-transition.opacity.duration.180ms
        class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        @click.self="closeDeleteModal()"
        @keydown.escape.window="closeDeleteModal()"
    >
        <div
            x-show="deleteOpen"
            x-transition:enter="transition ease-out duration-220"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="w-full max-w-md bg-white"
        >
            <div class="px-5 py-4 border-b-2 border-black bg-cream-dark">
                <h3 class="text-sm font-semibold uppercase">Confirmar eliminación</h3>
            </div>
            <div class="p-5 text-sm">
                <p>Vas a eliminar esta incidencia. Esta acción no se puede deshacer.</p>
                <div class="mt-5 flex gap-2 justify-end">
                    <button type="button" @click="closeDeleteModal()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                        Cancelar
                    </button>
                    <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 border-2 border-red-700 bg-red-700 text-white text-xs uppercase interactive-btn">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
{{-- Lógica Alpine para el modal de eliminación --}}
function incidenciaShow() {
    return {
        deleteOpen: false,
        openDeleteModal() { this.deleteOpen = true; },
        closeDeleteModal() { this.deleteOpen = false; }
    }
}
</script>
@endpush
