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
        body {
            font-family: 'IBM Plex Mono', monospace;
        }
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

                    <!-- Comentarios -->
                    <div class="border-t border-gray-300 pt-4">
                        <h3 class="text-xs uppercase font-semibold mb-3">Comentarios</h3>
                        
                    <div id="modalComentarios" class="space-y-3 max-h-48 overflow-y-auto"></div>
                
                    <!-- Formulario nuevo comentario -->
                    <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
                        @csrf
                        <input type="hidden" id="modalIncidenciaId" name="incidencia_id">
                        <textarea name="contenido" placeholder="Añadir comentario..." class="w-full border-2 border-black p-2 text-sm bg-cream" required></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase">Comentar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
function abrirModal(incidencia) {
    document.getElementById('modalTitulo').textContent = 'INC-' + String(incidencia.id).padStart(3, '0');
    document.getElementById('modalDescripcion').textContent = incidencia.descripcion;
    document.getElementById('modalPrioridad').textContent = incidencia.prioridad;
    document.getElementById('modalEstado').textContent = incidencia.estado;
    document.getElementById('modalCreador').textContent = incidencia.user ? incidencia.user.name : 'Unknown';
    document.getElementById('modalIncidenciaId').value = incidencia.id;
    
    // Renderizar comentarios
    const comentariosDiv = document.getElementById('modalComentarios');
    if (incidencia.comments && incidencia.comments.length > 0) {
        comentariosDiv.innerHTML = incidencia.comments.map(c => `
            <div class="border border-gray-300 p-3 bg-cream">
                <div class="text-xs font-bold">${c.user ? c.user.name : 'Usuario'}</div>
                <div class="text-sm">${c.contenido}</div>
            </div>
        `).join('');
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
                <h1 class="text-2xl font-semibold tracking-tight">INCIDENT MANAGER</h1>
                <div class="text-right text-xs">
                    <div class="mb-1">v2.1 | {{ date('Y.m.d H:i') }}</div>
                </div>
            </div>
            <div class="px-6 py-3 bg-cream-dark text-xs flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-black rounded-full"></span>
                <span>SYSTEM ONLINE</span>
                <span class="ml-4">USER: {{ strtoupper(auth()->user()->name) }}</span>
                <span class="ml-4">LAST SYNC: 2 MIN AGO</span>
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
                <div class="text-5xl font-light mb-2">{{ str_pad($cerradas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-xs">Closed incidents</div>
            </a>
        </div>

        <!-- Filter & Search
        <div class="border-3 border-black bg-white mb-6 p-6">
            <div class="text-xs uppercase tracking-wide font-semibold mb-4">Filter & Search</div>
            <div class="flex flex-wrap gap-3 items-center">
                <input 
                    type="text" 
                    placeholder="Search incidents..."
                    class="flex-1 min-w-[300px] px-4 py-3 border-2 border-black bg-cream-dark focus:bg-white focus:outline-none text-sm"
                >
                <button class="px-6 py-3 border-2 border-black bg-black text-white text-xs uppercase tracking-wide font-semibold hover:bg-gray-800 transition-colors">
                    All
                </button>
                <button class="px-6 py-3 border-2 border-black bg-white text-xs uppercase tracking-wide font-semibold hover:bg-cream-dark transition-colors">
                    Critical
                </button>
                <button class="px-6 py-3 border-2 border-black bg-white text-xs uppercase tracking-wide font-semibold hover:bg-cream-dark transition-colors">
                    Open
                </button>
                <button class="px-6 py-3 border-2 border-black bg-white text-xs uppercase tracking-wide font-semibold hover:bg-cream-dark transition-colors">
                    In Progress
                </button>
                <a href="{{ route('incidencias.create') }}" class="px-6 py-3 border-2 border-black bg-black text-white text-xs uppercase tracking-wide font-semibold hover:bg-gray-800 transition-colors">
                    + New
                </a>
            </div>
        </div> -->

        <!-- Incidents Table -->
        <div class="border-3 border-black bg-white">
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-cream-dark border-b-2 border-black text-xs uppercase tracking-wide font-semibold">
                <div class="col-span-1">ID</div>
                <div class="col-span-5">Title</div>
                <div class="col-span-2">Priority</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-2">Assigned</div>
            </div>

            <!-- Table Rows -->
            @forelse($incidencias as $inc)
            <!-- <div class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-cream-dark"> -->
            <div class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-cream-dark cursor-pointer" onclick='abrirModal(@json($inc))'>
                <div class="col-span-1 font-semibold text-sm">INC-{{ str_pad($inc->id, 3, '0', STR_PAD_LEFT) }}</div>
                <div class="col-span-5">
                    <div class="font-medium text-sm mb-1">{{ $inc->titulo }}</div>
                    <div class="text-xs text-gray-custom">{{ Str::limit($inc->descripcion, 60) }}</div>
                </div>
                <div class="col-span-2">
                    <span class="inline-block px-3 py-1 border-2 border-black {{ $inc->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }} text-xs uppercase">
                        {{ $inc->prioridad }}
                    </span>
                </div>
                <div class="col-span-2">
                    <span class="inline-block px-3 py-1 border-2 border-black bg-white text-xs uppercase">
                        {{ $inc->estado }}
                    </span>
                </div>
                <div class="col-span-2 flex items-center gap-2">
                 <div class="w-7 h-7 border-2 border-black bg-cream-dark flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr($inc->user->name, 0, 2)) }}
                    </div>
                    <span class="text-xs">{{ $inc->user->name }}</span>
                </div>
                </div>
                @empty
            <div class="px-6 py-8 text-center text-gray-custom">No hay incidencias.</div>
            @endforelse
            </div>

            <!-- Pagination
            <div class="flex items-center justify-center gap-2 px-6 py-4 border-t-2 border-black bg-cream-dark">
                <button class="w-9 h-9 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors text-sm font-semibold">‹</button>
                <button class="w-9 h-9 border-2 border-black bg-black text-white text-sm font-semibold">1</button>
                <button class="w-9 h-9 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors text-sm font-semibold">2</button>
                <button class="w-9 h-9 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors text-sm font-semibold">3</button>
                <button class="w-9 h-9 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors text-sm font-semibold">›</button>
            </div>
        </div> --->

        <!-- Bottom Actions -->
        <div class="mt-6 flex items-center justify-center gap-4">
        <a href="{{ route('incidencias.index') }}"
            class="px-6 py-3 border-2 border-black bg-black text-white text-xs uppercase tracking-wide font-semibold hover:bg-gray-800 transition-colors">
            My Incidents
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button 
                type="submit"
                class="px-6 py-3 border-2 border-black bg-white text-xs uppercase tracking-wide font-semibold hover:bg-cream-dark transition-colors">
            Logout
            </button>
    </form>
</div>
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