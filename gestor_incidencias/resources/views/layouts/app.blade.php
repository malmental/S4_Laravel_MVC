<!DOCTYPE html>
<html lang="es">
<head>
    {{-- Metadatos base del documento --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Incident Manager')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='%23333' d='M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6 997 0 0 0 15 2'/><circle cx='7' cy='17' r='5' fill='currentColor'/><path d='M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7' opacity='.5'/></svg>" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Pre-cálculo de transición de entrada entre vistas principales --}}
    <script>
        window.__softEnter = sessionStorage.getItem('softNav') === '1';
        if (window.__softEnter) {
            document.documentElement.classList.add('soft-enter');
            sessionStorage.removeItem('softNav');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Estilos globales del layout (paleta, animación y utilidades de visibilidad) --}}
    <style>
        :root {
            --cream: #e8e6e3;
            --cream-dark: #d4d2cf;
        }

        body { font-family: 'IBM Plex Mono', monospace; }
        .bg-cream { background-color: var(--cream); }
        .bg-cream-dark { background-color: var(--cream-dark); }
        .border-3 { border-width: 3px; }
        /* Velocidad transicion */
        .soft-enter .page-main {
            animation: page-turn-lite-enter 440ms cubic-bezier(0.22, 0.61, 0.36, 1) both; 
            transform-origin: 100% 50%;
            will-change: transform, opacity, box-shadow, filter;
        }

        @keyframes page-turn-lite-enter {
            from {
                opacity: 0.86;
                transform: translateX(14px) scale(0.998);
                box-shadow: -18px 0 28px rgba(0, 0, 0, 0.08);
                filter: saturate(0.94);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
                box-shadow: 0 0 0 rgba(0, 0, 0, 0);
                filter: saturate(1);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .soft-enter .page-main {
                animation: none;
            }
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-cream min-h-screen">
    
    {{-- Contenedor raíz con ancho máximo del panel --}}
    <div class="w-full max-w-7xl mx-auto p-4 md:p-6 overflow-x-auto">
        
        {{-- Header principal del sistema --}}
        <header class="border-black bg-white mb-6">
            
            {{-- Franja superior con marca y reloj --}}
            <div class="px-6 py-4 flex items-center justify-between border-b-2 border-black">
                <h1 class="text-2xl font-semibold tracking-tight">INCIDENSLY MANAGER</h1>
                <div class="text-right text-xs">
                    <div id="headerTime">v2.1 | --</div>
                </div>
            </div>

            {{-- Franja inferior con estado del sistema y acciones del usuario --}}
            <div class="px-6 py-4 bg-cream-dark text-sm flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-black rounded-full"></span>
                    <span class="font-semibold">SYSTEM ONLINE</span>
                </div>

                <div class="flex items-center gap-3 flex-wrap justify-end">
                    <span class="mr-8">USER: {{ strtoupper(auth()->user()->name ?? 'ADMIN') }}</span>

                    <a href="{{ route('incidencias.index') }}" onclick="sessionStorage.setItem('softNav','1')" class="px-3 py-1 border border-black bg-black text-white text-xs uppercase hover:bg-gray-800 interactive-btn">
                        My Incidents
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline" onsubmit="sessionStorage.setItem('softNav','1')">
                        @csrf
                        <button type="submit" class="px-3 py-1 border border-black bg-white text-xs uppercase hover:bg-gray-200 interactive-btn">
                            Logout
                        </button>
                    </form>

                    <form
                        method="POST"
                        action="{{ route('profile.destroy') }}"
                        class="inline"
                        onsubmit="
                            const confirmed = confirm('¿Estás seguro de eliminar tu usuario?');
                            if (confirmed) {
                                sessionStorage.setItem('softNav','1');
                            } else {
                                sessionStorage.removeItem('softNav');
                            }
                            return confirmed;
                        "
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 border border-red-600 bg-red-600 text-white text-xs uppercase hover:bg-red-700 interactive-btn">
                            Destroy User
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Contenido inyectado por cada vista --}}
        <main class="page-main">
            @yield('content')
        </main>
    </div>

    {{-- Script de reloj del header --}}
    <script>
        function updateHeaderTime() {
            const now = new Date();
            const formatted = now.getFullYear() + '.' +
                String(now.getMonth() + 1).padStart(2, '0') + '.' +
                String(now.getDate()).padStart(2, '0') + ' ' +
                String(now.getHours()).padStart(2, '0') + ':' +
                String(now.getMinutes()).padStart(2, '0');

            const el = document.getElementById('headerTime');
            if (el) el.textContent = 'v2.1 | ' + formatted;
        }

        updateHeaderTime();
        setInterval(updateHeaderTime, 60000);
    </script>

    {{-- Punto de inyección para scripts específicos de cada vista --}}
    @stack('scripts')
</body>
</html>