@extends('layouts.app')
@section('title', 'Mis Incidencias')

@section('content')
{{-- Contenedor Alpine principal de la vista de incidencias --}}
<div x-data="incidenciasIndex()">
    
    {{-- Tarjeta principal del listado --}}
    <div class="bg-white">
        
        {{-- Cabecera: título y navegación/creación --}}
        <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
            <h2 class="text-lg font-semibold uppercase tracking-wide">Mis Incidencias</h2>
            <div class="flex gap-2">
                {{--
                <a href="{{ route('dashboard') }}" data-soft-nav="1" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                    Dashboard
                </a>
                --}}
                <button type="button" @click="openCreateModal()" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                    + Nueva Incidencia
                </button>
            </div>
        </div>

        {{-- Lista de incidencias con acciones por fila --}}
        <div class="divide-y divide-gray-300">
            @forelse($incidencias as $incidencia)
                
                {{-- Payload serializado para modales Ver/Editar --}}
                @php
                    $viewPayload = [
                        'id' => $incidencia->id,
                        'titulo' => $incidencia->titulo,
                        'descripcion' => $incidencia->descripcion,
                        'prioridad' => $incidencia->prioridad,
                        'estado' => $incidencia->estado,
                        'created_at' => optional($incidencia->created_at)->format('Y-m-d H:i'),
                        'tags' => $incidencia->tags->pluck('nombre')->values(),
                        'tags_string' => $incidencia->tags->pluck('nombre')->implode(' '),
                    ];
                @endphp
                
                {{-- Fila individual de incidencia --}}
                <div
                    class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-cream-dark transition-colors duration-150 items-center cursor-pointer"
                    @click='openViewModal(@json($viewPayload))'
                >
                    <div class="col-span-12 md:col-span-1 font-semibold">
                        INC-{{ str_pad($incidencia->id, 3, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <div class="font-medium">{{ $incidencia->titulo }}</div>
                        <div class="text-xs text-gray-500">{{ Str::limit($incidencia->descripcion, 70) }}</div>
                    </div>

                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 border-2 border-black text-xs uppercase {{ $incidencia->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }}">
                            {{ $incidencia->prioridad }}
                        </span>
                    </div>

                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 border-2 border-black text-xs uppercase bg-white">
                            {{ $incidencia->estado }}
                        </span>
                    </div>

                    {{-- Acciones de fila: ver, editar y eliminar --}}
                    <div class="col-span-12 md:col-span-3 flex gap-2 md:justify-end">
                        {{--
                        <button
                            type="button"
                            @click='openViewModal(@json($viewPayload))'
                            class="px-3 py-1 border-2 border-black bg-white text-xs uppercase interactive-btn"
                        >
                            Ver
                        </button>
                        --}}
                        <button
                            type="button"
                            @click.stop='openEditModal(@json($viewPayload))'
                            class="px-3 py-1 border-2 border-black bg-white text-xs uppercase interactive-btn"
                        >
                            Editar
                        </button>
                        <button
                            type="button"
                            @click.stop="openDeleteModal('{{ route('incidencias.destroy', $incidencia->id) }}', 'INC-{{ str_pad($incidencia->id, 3, '0', STR_PAD_LEFT) }}')"
                            class="px-3 py-1 border border-red-700 bg-red-700 text-white text-xs uppercase interactive-btn"
                        >
                            Eliminar
                        </button>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-sm text-gray-500">No hay incidencias.</div>
            @endforelse
        </div>

        {{-- Paginación del listado --}}
        <div class="px-6 py-4 border-t-2 border-black bg-cream-dark">
            {{ $incidencias->links() }}
        </div>
    </div>

    {{-- Modal: vista rápida de una incidencia --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="viewOpen"
            x-transition.opacity.duration.180ms
            class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
            @click.self="closeViewModal()"
            @keydown.escape.window="closeViewModal()"
        >
            <div
                x-show="viewOpen"
                x-transition.opacity.duration.120ms
                class="w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white"
            >
                {{-- Cabecera del modal Ver --}}
                <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
                    <h3 class="text-sm font-semibold uppercase" x-text="viewData ? `Detalle · INC-${String(viewData.id).padStart(3, '0')}` : 'Detalle'"></h3>
                    <button type="button" @click="closeViewModal()" class="text-2xl font-bold hover:text-gray-600 interactive-btn">&times;</button>
                </div>
                {{-- Contenido del modal Ver --}}
                <div class="p-6 space-y-4" x-show="viewData">
                    <div>
                        <p class="text-xs uppercase text-gray-500 mb-1">Título</p>
                        <p class="font-medium" x-text="viewData?.titulo"></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500 mb-1">Descripción</p>
                        <div class="p-4 border border-gray-300 bg-cream text-sm" x-text="viewData?.descripcion"></div>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <p class="text-xs uppercase text-gray-500 mb-1">Prioridad</p>
                            <span class="px-2 py-1 border-2 border-black text-xs uppercase" :class="viewData?.prioridad === 'alta' ? 'bg-black text-white' : 'bg-white'" x-text="viewData?.prioridad"></span>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-500 mb-1">Estado</p>
                            <span class="px-2 py-1 border-2 border-black text-xs uppercase bg-white" x-text="viewData?.estado"></span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500 mb-1">Tags</p>
                        <div class="flex flex-wrap gap-1">
                            <template x-if="viewData?.tags?.length">
                                <template x-for="tag in viewData.tags" :key="tag">
                                    <span class="px-2 py-1 text-xs bg-gray-300/50 text-gray-700 rounded" x-text="'#' + tag"></span>
                                </template>
                            </template>
                            <template x-if="!viewData?.tags?.length">
                                <span class="text-xs text-gray-400">—</span>
                            </template>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500 mb-1">Creada</p>
                        <p class="text-sm" x-text="viewData?.created_at || '-'"></p>
                    </div>
                </div>
                
                {{-- Acciones del modal Ver --}}
                <div class="px-6 py-4 border-t-2 border-black bg-cream-dark flex justify-end gap-2">
                    <template x-if="viewData?.id">
                        <button type="button" @click="openEditFromView()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">Editar</button>
                    </template>
                    <button type="button" @click="closeViewModal()" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">Cerrar</button>
                </div>
            </div>
        </div>
    </template>

    {{-- Modal: creación de incidencia --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="createOpen"
            x-transition.opacity.duration.180ms
            class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
            @click.self="closeCreateModal()"
            @keydown.escape.window="closeCreateModal()"
        >
            <div
                x-show="createOpen"
                x-transition.opacity.duration.120ms
                class="w-full max-w-3xl max-h-[92vh] overflow-y-auto bg-white"
            >
                {{-- Cabecera del modal Crear --}}
                <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
                    <h3 class="text-sm font-semibold uppercase">Nueva incidencia</h3>
                    <button type="button" @click="closeCreateModal()" class="text-2xl font-bold hover:text-gray-600 interactive-btn">&times;</button>
                </div>

                {{-- Formulario de creación --}}
                <form action="{{ route('incidencias.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs uppercase mb-2">Título</label>
                        <input type="text" name="titulo" x-model="createData.titulo" required class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs uppercase mb-2">Descripción</label>
                        <textarea name="descripcion" rows="5" x-model="createData.descripcion" required class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs uppercase mb-2">Tags</label>
                        <input type="text" name="tags" x-model="createData.tags_string" placeholder="backend urgente bug" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">Separa con espacios.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase mb-2">Estado</label>
                            <select name="estado" x-model="createData.estado" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                                <option value="abierta">Abierta</option>
                                <option value="en_proceso">En proceso</option>
                                <option value="cerrada">Cerrada</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs uppercase mb-2">Prioridad</label>
                            <select name="prioridad" x-model="createData.prioridad" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                    </div>

                    {{-- Acciones del modal Crear --}}
                    <div class="pt-2 flex gap-2 justify-end">
                        <button type="button" @click="closeCreateModal()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                            Crear incidencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    {{-- Modal: edición de incidencia (PUT) --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="editOpen"
            x-transition.opacity.duration.180ms
            class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
            @click.self="closeEditModal()"
            @keydown.escape.window="closeEditModal()"
        >
            <div
                x-show="editOpen"
                x-transition.opacity.duration.120ms
                class="w-full max-w-3xl max-h-[92vh] overflow-y-auto bg-white"
            >
                {{-- Cabecera del modal Editar --}}
                <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
                    <h3 class="text-sm font-semibold uppercase" x-text="editData?.id ? `Editar · INC-${String(editData.id).padStart(3, '0')}` : 'Editar incidencia'"></h3>
                    <button type="button" @click="closeEditModal()" class="text-2xl font-bold hover:text-gray-600 interactive-btn">&times;</button>
                </div>

                {{-- Formulario de edición --}}
                <form :action="editAction" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs uppercase mb-2">Título</label>
                        <input type="text" name="titulo" x-model="editData.titulo" required class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs uppercase mb-2">Descripción</label>
                        <textarea name="descripcion" rows="5" x-model="editData.descripcion" required class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs uppercase mb-2">Tags</label>
                        <input type="text" name="tags" x-model="editData.tags_string" placeholder="backend urgente bug" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">Separa con espacios.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase mb-2">Estado</label>
                            <select name="estado" x-model="editData.estado" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                                <option value="abierta">Abierta</option>
                                <option value="en_proceso">En proceso</option>
                                <option value="cerrada">Cerrada</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs uppercase mb-2">Prioridad</label>
                            <select name="prioridad" x-model="editData.prioridad" class="w-full px-4 py-2 border-2 border-black bg-cream-dark focus:outline-none">
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                    </div>

                    {{-- Acciones del modal Editar --}}
                    <div class="pt-2 flex gap-2 justify-end">
                        <button type="button" @click="closeEditModal()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    {{-- Modal: confirmación de eliminación --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="deleteOpen"
            x-transition.opacity.duration.180ms
            class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
            @click.self="closeDeleteModal()"
            @keydown.escape.window="closeDeleteModal()"
        >
            <div
                x-show="deleteOpen"
                x-transition.opacity.duration.120ms
                class="w-full max-w-md bg-white"
            >
                <div class="px-5 py-4 border-b-2 border-black bg-cream-dark">
                    <h3 class="text-sm font-semibold uppercase">Confirmar eliminación</h3>
                </div>
                <div class="p-5 text-sm">
                    <p>Vas a eliminar <span class="font-semibold" x-text="deleteLabel"></span>. Esta acción no se puede deshacer.</p>
                    <div class="mt-5 flex gap-2 justify-end">
                        <button type="button" @click="closeDeleteModal()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                            Cancelar
                        </button>
                        <form :action="deleteAction" method="POST">
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
    </template>
</div>
@endsection

@push('scripts')
<script>
{{-- Estado Alpine y handlers para modales de incidencias --}}
function incidenciasIndex() {
    return {
        viewOpen: false,
        viewData: null,
        createOpen: false,
        createData: {
            titulo: '',
            descripcion: '',
            estado: 'abierta',
            prioridad: 'media',
            tags_string: ''
        },
        editOpen: false,
        editAction: '',
        editData: {
            id: null,
            titulo: '',
            descripcion: '',
            estado: 'abierta',
            prioridad: 'media',
            tags_string: ''
        },
        deleteOpen: false,
        deleteAction: '',
        deleteLabel: '',
        openViewModal(payload) {
            this.viewData = payload;
            this.viewOpen = true;
        },
        closeViewModal() {
            this.viewOpen = false;
            this.viewData = null;
        },
        openCreateModal() {
            this.createData = {
                titulo: '',
                descripcion: '',
                estado: 'abierta',
                prioridad: 'media',
                tags_string: ''
            };
            this.createOpen = true;
        },
        closeCreateModal() {
            this.createOpen = false;
        },
        openEditModal(payload) {
            this.editAction = `/incidencias/${payload.id}`;
            this.editData = {
                id: payload.id,
                titulo: payload.titulo ?? '',
                descripcion: payload.descripcion ?? '',
                estado: payload.estado ?? 'abierta',
                prioridad: payload.prioridad ?? 'media',
                tags_string: payload.tags_string ?? ((payload.tags ?? []).join(' '))
            };
            this.editOpen = true;
        },
        openEditFromView() {
            if (!this.viewData?.id) return;
            this.openEditModal(this.viewData);
            this.closeViewModal();
        },
        closeEditModal() {
            this.editOpen = false;
        },
        openDeleteModal(action, label) {
            this.deleteAction = action;
            this.deleteLabel = label;
            this.deleteOpen = true;
        },
        closeDeleteModal() {
            this.deleteOpen = false;
        }
    }
}
</script>
@endpush
