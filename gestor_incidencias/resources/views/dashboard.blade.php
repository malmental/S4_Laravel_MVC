@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- Contenedor Alpine del dashboard y sus interacciones de detalle --}}
<div x-data="dashboardModal()">

    {{-- Modal global de detalle de incidencia --}}
    <template x-teleport="body">
    <div
        x-cloak
        x-show="open"
        x-transition.opacity.duration.180ms
        class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
        @click.self="closeModal()"
        @keydown.escape.window="closeModal()"
    >
        <div
            x-show="open"
            x-transition.opacity.duration.120ms
            class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto mx-auto"
        >
            {{-- Cabecera del modal con identificador de incidencia --}}
            <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
                <h2 class="text-lg font-semibold uppercase" x-text="modalTitle"></h2>
                <button @click="closeModal()" class="text-2xl font-bold hover:text-gray-600 interactive-btn">&times;</button>
            </div>

            {{-- Cuerpo del modal: descripción, metadatos, tags y comentarios --}}
            <div class="p-6" x-show="incidencia">
                <p class="mb-4 text-sm" x-text="incidencia?.descripcion"></p>

                <div class="flex gap-4 mb-4">
                    <span class="px-2 py-1 border border-black text-xs uppercase" x-text="incidencia?.prioridad"></span>
                    <span class="px-2 py-1 border border-black text-xs uppercase" x-text="incidencia?.estado"></span>
                </div>

                <div class="text-xs text-gray-500 mb-4">
                    Creador: <span x-text="incidencia?.user?.name ?? 'Unknown'"></span>
                </div>

                <div class="mb-4">
                    <span class="text-xs text-gray-500 mr-2">Tags:</span>
                    <template x-if="(incidencia?.tags?.length ?? 0) > 0">
                        <span>
                            <template x-for="tag in incidencia.tags" :key="tag.id">
                                <span class="px-2 py-1 text-xs bg-gray-300/50 text-gray-700 rounded mr-1" x-text="'#' + tag.nombre"></span>
                            </template>
                        </span>
                    </template>
                    <template x-if="!(incidencia?.tags?.length ?? 0)">
                        <span class="text-xs text-gray-400">—</span>
                    </template>
                </div>

                {{-- Bloque de comentarios y formulario de nuevo comentario --}}
                <div class="border-t border-gray-300 pt-4">
                    <h3 class="text-xs uppercase font-semibold mb-3">Comentarios</h3>

                    <div class="space-y-3 max-h-48 overflow-y-auto">
                        <template x-if="(incidencia?.comments?.length ?? 0) > 0">
                            <div>
                                <template x-for="c in incidencia.comments" :key="c.id">
                                    <div class="mb-2">
                                        <div class="border border-gray-300 p-3 bg-cream relative">
                                            <template x-if="canDeleteComment(c)">
                                                <form :action="`/comments/${c.id}`" method="POST" class="absolute top-2 right-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs leading-none font-bold text-gray-600 hover:text-red-700 interactive-btn" title="Eliminar comentario" aria-label="Eliminar comentario">&times;</button>
                                                </form>
                                            </template>
                                            <div class="text-xs font-bold pr-5" x-text="c.user?.name ?? 'Usuario'"></div>
                                            <div class="text-sm pr-5" x-text="c.contenido"></div>
                                        </div>

                                        <template x-if="(c.replies?.length ?? 0) > 0">
                                            <div class="mt-2">
                                                <template x-for="r in c.replies" :key="r.id">
                                                    <div class="border border-gray-300 p-3 ml-6 mb-2 bg-cream-dark relative">
                                                        <template x-if="canDeleteComment(r)">
                                                            <form :action="`/comments/${r.id}`" method="POST" class="absolute top-2 right-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-xs leading-none font-bold text-gray-600 hover:text-red-700 interactive-btn" title="Eliminar comentario" aria-label="Eliminar comentario">&times;</button>
                                                            </form>
                                                        </template>
                                                        <div class="text-xs font-bold pr-5" x-text="r.user?.name ?? 'Usuario'"></div>
                                                        <div class="text-sm pr-5" x-text="r.contenido"></div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="!(incidencia?.comments?.length ?? 0)">
                            <p class="text-xs text-gray-500">Sin comentarios</p>
                        </template>
                    </div>

                    <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="incidencia_id" :value="incidencia?.id ?? ''">
                        <textarea name="contenido" placeholder="Añadir comentario..." class="w-full p-2 text-sm bg-cream border-none" required></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                        Comentar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </template>
    
    {{-- Tarjetas de estado/prioridad que funcionan como filtros rápidos --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 mb-6">
        <a href="{{ $filterUrls['critical'] }}" onclick="sessionStorage.removeItem('softNav')" class="block border-2 border-black {{ in_array('alta', $prioridades) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark interactive-card">
            <div class="text-xs uppercase tracking-wide mb-3">Critical</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($altaPrioridad ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">High priority incidents</div>
        </a>
        <a href="{{ $filterUrls['open'] }}" onclick="sessionStorage.removeItem('softNav')" class="block border-2 border-black {{ in_array('abierta', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark interactive-card">
            <div class="text-xs uppercase tracking-wide mb-3">Open</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($abiertas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">Open incidents</div>
        </a>
        <a href="{{ $filterUrls['inProgress'] }}" onclick="sessionStorage.removeItem('softNav')" class="block border-2 border-black {{ in_array('en_proceso', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark interactive-card">
            <div class="text-xs uppercase tracking-wide mb-3">In process</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($enProceso ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">In process incidents</div>
        </a>
        <a href="{{ $filterUrls['closed'] }}" onclick="sessionStorage.removeItem('softNav')" class="block border-2 border-black {{ in_array('cerrada', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark interactive-card">
            <div class="text-xs uppercase tracking-wide mb-3">Closed</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($cerradas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">Closed incidents</div>
        </a>
    </div>

    {{-- Buscador por tag (filtro textual) --}}
    <div class="mb-6 border-2 border bg-white p-4">
        <form method="GET" action="{{ route('dashboard') }}" class="flex gap-4 items-center" onsubmit="sessionStorage.removeItem('softNav')">
            <input type="text" name="tag" placeholder="Buscar por hashtag..." value="{{ request('tag') }}" class="border-2 border-black p-2 text-xs flex-1">
            <button class="px-16 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">Search</button>
        </form>
    </div>

    {{-- Tabla/listado de incidencias con apertura de detalle al hacer click --}}
    <div class="border-2 bg-white">
        
        {{-- Encabezado de columnas --}}
        <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-cream-dark border-b-2 border-black text-xs uppercase tracking-wide font-semibold">
            <div class="col-span-1">ID</div>
            <div class="col-span-4">Title</div>
            <div class="col-span-2 text-center">Tags</div>
            <div class="col-span-2 text-center">Priority</div>
            <div class="col-span-3 text-center">Status</div>
        </div>

        {{-- Filas de incidencias (con estado vacío cuando no hay datos) --}}
        <div class="divide-y divide-gray-300">
            @forelse($incidencias as $inc)
                <div
                    class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-cream-dark transition-colors duration-150 items-center cursor-pointer"
                    @click='openModal(@json($inc))'
                >
                    <div class="col-span-1 font-semibold">
                        INC-{{ str_pad($inc->id, 3, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="col-span-4">
                        <div class="font-medium">{{ $inc->titulo }}</div>
                        <div class="text-xs text-gray-500">{{ Str::limit($inc->descripcion, 50) }}</div>
                    </div>

                    <div class="col-span-2 flex flex-wrap gap-1">
                        @forelse($inc->tags as $tag)
                            <span class="px-2 py-1 text-xs bg-gray-300/50 text-gray-700 rounded whitespace-nowrap">#{{ $tag->nombre }}</span>
                        @empty
                            <span class="text-xs text-gray-400">—</span>
                          @endforelse
                    </div>

                    <div class="col-span-2 text-center">
                        <span class="px-2 py-1 border-2 border-black text-xs uppercase {{ $inc->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }}">
                            {{ $inc->prioridad }}
                        </span>
                    </div>

                    <div class="col-span-3 text-center">
                        <span class="px-2 py-1 border-2 border-black text-xs uppercase bg-white">
                            {{ $inc->estado }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">No hay incidencias.</div>
            @endforelse
        </div>
    </div>

    {{-- Paginación del listado --}}
    <div class="px-6 py-4 border-t-2 border-black bg-cream-dark">
        {{ $incidencias->links() }}
    </div>
</div>

{{-- Lógica Alpine local para abrir/cerrar el modal de detalle --}}
<script>
function dashboardModal() {
    return {
        currentUserId: {{ auth()->id() ?? 'null' }},
        open: false,
        incidencia: null,
        get modalTitle() {
            if (!this.incidencia) return '';
            return `INC-${String(this.incidencia.id).padStart(3, '0')}`;
        },
        openModal(item) {
            this.incidencia = item;
            this.open = true;
        },
        canDeleteComment(comment) {
            if (!comment || this.currentUserId === null) return false;
            return Number(comment.user_id ?? comment.user?.id) === Number(this.currentUserId);
        },
        closeModal() {
            this.open = false;
        }
    }
}
</script>
@endsection
