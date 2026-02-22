@php
$user = auth()->user();
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
            
            <!-- Critical (Prioridad Alta) -->
            <div class="border-2 border-black bg-white p-6 text-center">
                <div class="text-xs uppercase tracking-wide text-gray-custom mb-3">Critical</div>
                <div class="text-5xl font-light mb-2">{{ str_pad($altaPrioridad ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-xs text-gray-custom">High priority incidents</div>
            </div>
            
            <!-- Open -->
            <div class="border-2 border-black bg-white p-6 text-center">
                <div class="text-xs uppercase tracking-wide text-gray-custom mb-3">Open</div>
                <div class="text-5xl font-light mb-2">{{ str_pad($abiertas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-xs text-gray-custom">Pending assignment</div>
            </div>
            
            <!-- In Progress -->
            <div class="border-2 border-black bg-white p-6 text-center">
                <div class="text-xs uppercase tracking-wide text-gray-custom mb-3">In Progress</div>
                <div class="text-5xl font-light mb-2">{{ str_pad($enProceso ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-xs text-gray-custom">Currently being handled</div>
            </div>
            
            <!-- Resolved -->
            <div class="border-2 border-black bg-white p-6 text-center">
                <div class="text-xs uppercase tracking-wide text-gray-custom mb-3">Resolved</div>
                <div class="text-5xl font-light mb-2">{{ str_pad($cerradas ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-xs text-gray-custom">Closed incidents</div>
            </div>
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
            @forelse($user->incidencias as $inc)
            <div class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-cream-dark">
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