@php
$user = auth()->user();
$prioridades = $prioridades ?? [];
$estados = $estados ?? [];
use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Incident Manager</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='%23333' d='M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6.997 0 0 0 15 2'/><circle cx='7' cy='17' r='5' fill='currentColor'/><path d='M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7' opacity='.5'/></svg>" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#e8e6e3',
                        'cream-dark': '#d4d2cf',
                        'gray-custom': '#666666',
                    },
                    fontFamily: {
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>

<!-- Modal Overlay -->
<div id="incidenciaModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="border-3 border-black bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
            <h2 id="modalTitulo" class="text-lg font-semibold uppercase">INC-001</h2>
            <button onclick="cerrarModal()" class="text-2xl font-bold hover:text-gray-600">&times;</button>
        </div>
        
        <!-- Contenido -->
        <div class="p-6">
            <p id="modalDescripcion" class="mb-4 text-sm"></p>
            <div class="flex gap-4 mb-4">
                <span id="modalPrioridad" class="px-2 py-1 border border-black text-xs uppercase"></span>
                <span id="modalEstado" class="px-2 py-1 border border-black text-xs uppercase"></span>
            </div>
            <div class="text-xs text-gray-500 mb-4">Creador: <span id="modalCreador"></span></div>

            <!-- Tags -->
            <div class="mb-4">
                <span class="text-xs text-gray-500 mr-2">Tags:</span>
                <span id="modalTags"></span>
            </div>
            
            <!-- Comentarios -->
            <div class="border-t border-gray-300 pt-4">
                <h3 class="text-xs uppercase font-semibold mb-3">Comentarios</h3>
                <div id="modalComentarios" class="space-y-3 max-h-48 overflow-y-auto"></div>
                
                <!-- Formulario nuevo comentario -->
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

// Renderizar tags
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

    // Renderizar comentarios principales Y respuestas
    const comentariosDiv = document.getElementById('modalComentarios');
    if (incidencia.comments && incidencia.comments.length > 0) {
        comentariosDiv.innerHTML = incidencia.comments.map(c => {
            let html = `
                <div class="border border-gray-300 p-3 bg-cream mb-2">
                    <div class="text-xs font-bold">${c.user ? c.user.name : 'Usuario'}</div>
                    <div class="text-sm">${c.contenido}</div>
                </div>
            `;
            
        // Añadir respuestas si existen
        if (c.replies && c.replies.length > 0) {
            c.replies.forEach(r => {
                html += `
                    <div class="border border-gray-300 p-3 ml-6 mb-2 bg-cream-dark">
                        <div class="text-xs font-bold">${r.user ? r.user.name : 'Usuario'}</div>
                        <div class="text-sm">${r.contenido}</div>
                    </div>
                `;
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

// Cerrar modal al hacer click fuera
document.getElementById('incidenciaModal').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>

<body class="bg-cream min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="border-3 border-black bg-white mb-6">
            <div class="px-6 py-4 flex items-center justify-between border-b-2 border-black">
                <h1 class="text-2xl font-semibold tracking-tight flex items-center gap-2">
                    <a href="{{ route('home') }}">
                    INCIDENT MANAGER
                    </a>
                </h1>
                <div class="text-right text-xs">
                    <div class="mb-1">v2.1 | {{ date('Y.m.d H:i') }}</div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-cream-dark text-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-black rounded-full"></span>
                    <span class="font-semibold">SYSTEM ONLINE</span>
                </div>

                <div class="flex items-center gap-4">
                    <span>USER: {{ strtoupper(auth()->user()->name) }}</span>
                    <span>LAST SYNC: 2 MIN AGO</span>
                <a href="{{ route('incidencias.index') }}" class="ml-4 px-4 py-2 border border-black bg-black text-white text-xs uppercase hover:bg-gray-800">My Incidents</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-8 py-2 border border-black bg-white text-xs uppercase hover:bg-gray-200">Logout</button>
                </form>
            </div>
        </div>
    </div>
        
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <!-- Critical -->
        <a href="{{ $filterUrls['critical'] }}" class="block border-2 border-black {{ in_array('alta', $prioridades) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
            <div class="text-xs uppercase tracking-wide mb-3">Critical</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($altaPrioridad ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">High priority incidents</div>
        </a>
            
        <!-- Open -->
        <a href="{{ $filterUrls['open'] }}" class="block border-2 border-black {{ in_array('abierta', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
            <div class="text-xs uppercase tracking-wide mb-3">Open</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($abiertas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">Open incidents</div>
        </a>
            
        <!-- In Progress -->
        <a href="{{ $filterUrls['inProgress'] }}" class="block border-2 border-black {{ in_array('en_proceso', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
            <div class="text-xs uppercase tracking-wide mb-3">In process</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($enProceso ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="text-xs">In process incidents</div>
        </a>

        <!-- Closed -->
        <a href="{{ $filterUrls['closed'] }}" class="block border-2 border-black {{ in_array('cerrada', $estados) ? 'bg-black text-white' : 'bg-white' }} p-6 text-center hover:bg-cream-dark">
            <div class="text-xs uppercase tracking-wide mb-3">Closed</div>
            <div class="text-5xl font-light mb-2">{{ str_pad($cerradas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>                <div class="text-xs">Closed incidents</div>
        </a>
    </div>

    <!-- Search by Tag -->
    <div class="mb-6 border-2 border bg-white p-4">
        <form method="GET" action="{{ route('dashboard') }}" class="flex gap-4 items-center">
            <input 
            type="text"
            name="tag"
            placeholder="Buscar por hashtag..."
            value="{{ request('tag') }}"
            class="border-2 border-black p-2 text-xs flex-1">
                <button class="px-16 py-2 border-2 border-black bg-black text-white text-xs uppercase">
                    Search
                </button>
        </form>
    </div>

    <!-- Incidents Table -->
    <div class="border-3 border-black bg-white">

        <!-- Table Header -->
        <div class="flex items-center gap-2 md:gap-4 px-2 md:px-6 py-4 bg-cream-dark border-b-2 border-black text-xs uppercase tracking-wide font-semibold">

            <!-- ID -->
            <div class="w-16 md:w-20 shrink-0 hidden md:block">ID</div>

            <!-- Title - 50% -->
            <div class="flex-1 min-w-[200px]">Title</div>

            <!-- Mitad derecha (50%) - 3 columnas iguales -->
            <div class="flex-1 flex justify-between gap-2 md:gap-4">
                <div class="flex-1 shrink-0 text-center">Tags</div>
                <div class="flex-1 shrink-0 text-center">Priority</div>
                <div class="flex-1 shrink-0 text-center">Status</div>
            </div>
        </div>

        @forelse($incidencias as $inc)
    <div class="flex items-center gap-2 md:gap-4 px-2 md:px-6 py-3 md:py-5 hover:bg-cream-dark cursor-pointer" onclick='abrirModal(@json($inc))'>
    
    <!-- ID -->
    <div class="w-16 md:w-20 shrink-0 font-semibold text-sm hidden md:block">
        INC-{{ str_pad($inc->id, 3, '0', STR_PAD_LEFT) }}
    </div>
    
    <!-- Title - 50% -->
    <div class="flex-1 min-w-[200px]">
        <div class="font-medium text-sm mb-1">{{ $inc->titulo }}</div>
    </div>
    
    <!-- Mitad derecha (50%) - 3 columnas iguales -->
    <div class="flex-1 flex justify-between gap-2 md:gap-4">
        <!-- Tags -->
        <div class="flex-1 shrink-0 flex flex-wrap gap-1 justify-center">
            @forelse($inc->tags as $tag)
                <span class="px-2 py-1 text-xs bg-gray-300/50 text-gray-700 rounded">
                    #{{ $tag->nombre }}
                </span>
            @empty
                <span class="text-xs text-gray-400">—</span>
            @endforelse
        </div>
        
        <!-- Priority -->
        <div class="flex-1 shrink-0 flex justify-center">
            <span class="inline-block px-2 py-1 border-2 border-black {{ $inc->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }} text-xs uppercase">
                {{ $inc->prioridad }}
            </span>
        </div>
        
        <!-- Status -->
        <div class="flex-1 shrink-0 flex justify-center">
            <span class="inline-block px-2 py-1 border-2 border-black bg-white text-xs uppercase">
                {{ $inc->estado }}
            </span>
        </div>
    </div>
</div>
@empty
<div class="px-6 py-8 text-center text-gray-custom">No hay incidencias.</div>
@endforelse

</div>

    <script>
        // Update time in header
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
</body>
</html>