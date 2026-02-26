@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<!-- Modal Overlay -->
<div id="incidenciaModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="border-3 border-black bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
            <h2 id="modalTitulo" class="text-lg font-semibold uppercase">INC-001</h2>
            <button onclick="cerrarModal()" class="text-2xl font-bold hover:text-gray-600">&times;</button>
        </div>
        <div class="p-6">
            <p id="modalDescripcion" class="mb-4 text-sm"></p>
            <div class="flex gap-4 mb-4">
                <span id="modalPrioridad" class="px-2 py-1 border border-black text-xs uppercase"></span>
                <span id="modalEstado" class="px-2 py-1 border border-black text-xs uppercase"></span>
            </div>
            <div class="text-xs text-gray-500 mb-4">Creador: <span id="modalCreador"></span></div>
            <div class="mb-4">
                <span class="text-xs text-gray-500 mr-2">Tags:</span>
                <span id="modalTags"></span>
            </div>
            <div class="border-t border-gray-300 pt-4">
                <h3 class="text-xs uppercase font-semibold mb-3">Comentarios</h3>
                <div id="modalComentarios" class="space-y-3 max-h-48 overflow-y-auto"></div>
                <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
                    @csrf
                    <input type="hidden" id="modalIncidenciaId" name="incidencia_id">
                    <textarea name="contenido" placeholder="Añadir comentario..." class="w-full p-2 text-sm bg-cream border-none" required></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase">Comentar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function abrirModal(incidencia) {
    const tagsSpan = document.getElementById('modalTags');
    if (incidencia.tags && incidencia.tags.length > 0) {
        tagsSpan.innerHTML = incidencia.tags.map(tag => 
            `<span class="px-2 py-1 text-xs bg-gray-300/50 text-gray-700 rounded mr-1">#${tag.nombre}</span>`).join('');
    } else {
        tagsSpan.innerHTML = '<span class="text-xs text-gray-400">—</span>';
    }
    document.getElementById('modalTitulo').textContent = 'INC-' + String(incidencia.id).padStart(3, '0');
    document.getElementById('modalDescripcion').textContent = incidencia.descripcion;
    document.getElementById('modalPrioridad').textContent = incidencia.prioridad;
    document.getElementById('modalEstado').textContent = incidencia.estado;
    document.getElementById('modalCreador').textContent = incidencia.user ? incidencia.user.name : 'Unknown';
    document.getElementById('modalIncidenciaId').value = incidencia.id;
    const comentariosDiv = document.getElementById('modalComentarios');
    if (incidencia.comments && incidencia.comments.length > 0) {
        comentariosDiv.innerHTML = incidencia.comments.map(c => {
            let html = `<div class="border border-gray-300 p-3 bg-cream mb-2"><div class="text-xs font-bold">${c.user ? c.user.name : 'Usuario'}</div><div class="text-sm">${c.contenido}</div></div>`;
            if (c.replies && c.replies.length > 0) {
                c.replies.forEach(r => {
                    html += `<div class="border border-gray-300 p-3 ml-6 mb-2 bg-cream-dark"><div class="text-xs font-bold">${r.user ? r.user.name : 'Usuario'}</div><div class="text-sm">${r.contenido}</div></div>`;
                });
            }
            return html;
        }).join('');
    } else {
        comentariosDiv.innerHTML = '<p class="text-xs text-gray-500">Sin comentarios</p>';
    }
    document.getElementById('incidenciaModal').classList.remove('hidden');
}
function cerrarModal() {
    document.getElementById('incidenciaModal').classList.add('hidden');
}
document.getElementById('incidenciaModal').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>

<!-- Stats Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 mb-6">
    <a href="{{ $filterUrls['critical'] }}" class="block border-2 border-black {{ in_array('alta', $prioridades) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
        <div class="text-xs uppercase tracking-wide mb-3">Critical</div>
        <div class="text-5xl font-light mb-2">{{ str_pad($altaPrioridad ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="text-xs">High priority incidents</div>
    </a>
    <a href="{{ $filterUrls['open'] }}" class="block border-2 border-black {{ in_array('abierta', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
        <div class="text-xs uppercase tracking-wide mb-3">Open</div>
        <div class="text-5xl font-light mb-2">{{ str_pad($abiertas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="text-xs">Open incidents</div>
    </a>
    <a href="{{ $filterUrls['inProgress'] }}" class="block border-2 border-black {{ in_array('en_proceso', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
        <div class="text-xs uppercase tracking-wide mb-3">In process</div>
        <div class="text-5xl font-light mb-2">{{ str_pad($enProceso ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="text-xs">In process incidents</div>
    </a>
    <a href="{{ $filterUrls['closed'] }}" class="block border-2 border-black {{ in_array('cerrada', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
        <div class="text-xs uppercase tracking-wide mb-3">Closed</div>
        <div class="text-5xl font-light mb-2">{{ str_pad($cerradas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="text-xs">Closed incidents</div>
    </a>
</div>

<!-- Search by Tag -->
<div class="mb-6 border-2 border bg-white p-4">
    <form method="GET" action="{{ route('dashboard') }}" class="flex gap-4 items-center">
        <input type="text" name="tag" placeholder="Buscar por hashtag..." value="{{ request('tag') }}" class="border-2 border-black p-2 text-xs flex-1">
        <button class="px-16 py-2 border-2 border-black bg-black text-white text-xs uppercase">Search</button>
    </form>
</div>

<!-- Incidents Table - SIN Editar ni X -->
<div class="border-3 border-black bg-white">
    <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-cream-dark border-b-2 border-black text-xs uppercase tracking-wide font-semibold">
        <div class="col-span-1">ID</div>
        <div class="col-span-4">Title</div>
        <div class="col-span-2 text-center">Tags</div>
        <div class="col-span-2 text-center">Priority</div>
        <div class="col-span-3 text-center">Status</div>
    </div>
    <div class="divide-y divide-gray-300">
        @forelse($incidencias as $inc)
        <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-cream-dark items-center cursor-pointer" onclick='abrirModal(@json($inc))'>
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

<script>
    function updateTime() {
        const now = new Date();
        const formatted = now.getFullYear() + '.' + 
                        String(now.getMonth() + 1).padStart(2, '0') + '.' + 
                        String(now.getDate()).padStart(2, '0') + ' ' +
                        String(now.getHours()).padStart(2, '0') + ':' +
                        String(now.getMinutes()).padStart(2, '0');
        document.querySelectorAll('.text-right.text-xs div')[0].innerHTML = 'v2.1 | ' + formatted;
    }
    setInterval(updateTime, 60000);
    updateTime();
</script>
@endsection