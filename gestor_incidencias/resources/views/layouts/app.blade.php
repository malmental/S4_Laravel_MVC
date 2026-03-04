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
            animation: page-turn-lite-enter 220ms cubic-bezier(0.22, 0.61, 0.36, 1) both;
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

<body class="bg-cream min-h-screen" x-data="asciiSnake" @keydown.window="handleKey($event)">
    
    {{-- Contenedor raíz con ancho máximo del panel --}}
    <div class="w-full max-w-7xl mx-auto p-4 md:p-6 overflow-x-auto">
        
        {{-- Header principal del sistema --}}
        <header class="border-black bg-white mb-6">
            
            {{-- Franja superior con marca y reloj --}}
            <div class="px-6 py-4 flex items-center justify-between border-b-2 border-black">
                <h1 class="text-2xl font-semibold tracking-tight">INCIDENsly 𝒘ebApp</h1>
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

                    <a href="{{ route('dashboard') }}" data-soft-nav="1" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase hover:bg-gray-200 interactive-btn">
                        Dashboard
                    </a>

                    <a href="{{ route('incidencias.index') }}" data-soft-nav="1" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase hover:bg-gray-800 interactive-btn">
                        My Incidents
                    </a>

                    {{-- Trigger del mini-juego ASCII Snake --}}
                    <button type="button" @click="openGame()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase hover:bg-gray-200 interactive-btn inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12" aria-hidden="true">
                            <title>snake</title>
                            <path fill="currentColor" d="M10 11H1v-1H0v2h10Zm0 0h1V5h-1v4H9V7H8V2H7v5H6V4H4V2H3v1H1v1h2v1h2v2H2v1h6v1H2V8H1v2h9ZM0 5h1V4H0Zm0-2h1V2H0Zm5 0h1V2h1V1H4v1h1Zm0 0"/>
                        </svg>
                    </button>

                    <form
                        method="POST"
                        action="{{ route('profile.destroy') }}"
                        class="inline"
                        data-soft-nav="1"
                        onsubmit="return confirm('¿Estás seguro de eliminar tu usuario?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 border-2 border-red-700 bg-red-700 text-white text-xs uppercase hover:bg-red-700 interactive-btn">
                            Destroy User
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="inline" data-soft-nav="1">
                        @csrf
                        <button type="submit" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase hover:bg-gray-200 interactive-btn">
                            Logout
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

    {{-- Modal global del juego: overlay + panel --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="gameOpen"
            x-transition.opacity.duration.180ms
            class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
            @click.self="closeGame()"
            @keydown.escape.window="closeGame()"
        >
            <div
                x-show="gameOpen"
                x-transition.opacity.duration.120ms
                class="w-full max-w-5xl max-h-[92vh] overflow-y-auto bg-white border-2 border-black"
            >
                {{-- Cabecera del modal con titulo y ayuda de controles --}}
                <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-semibold uppercase">ASCII Snake 32x32</h3>
                        <p class="text-xs mt-1">Controles: Flechas o WASD</p>
                    </div>
                    <button type="button" @click="closeGame()" class="text-2xl leading-none font-bold hover:text-gray-600 interactive-btn">&times;</button>
                </div>

                {{-- Contenido del juego: acciones, estado y tablero --}}
                <div class="p-4 md:p-6 space-y-4">
                    {{-- Controles de partida y estado actual --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" @click="startGame()" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                            Iniciar / Reiniciar
                        </button>
                        <button type="button" @click="togglePause()" class="px-4 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn" :disabled="!running || gameOver">
                            <span x-text="paused ? 'Reanudar' : 'Pausar'"></span>
                        </button>
                        <span class="text-xs border-2 border-black px-3 py-2 bg-cream-dark uppercase">Score: <strong x-text="score"></strong></span>
                        <span x-show="gameOver" class="text-xs border-2 border-red-700 px-3 py-2 bg-red-700 text-white uppercase">Game Over</span>
                    </div>

                    {{-- Tablero ASCII renderizado en texto monoespaciado --}}
                    <div class="ascii-snake-frame border-2 border-black bg-cream">
                        <pre class="ascii-snake-board" x-text="boardText"></pre>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- Script de reloj del header --}}
    <script>
        function enableSoftNav(trigger) {
            if (!trigger) {
                return;
            }
            sessionStorage.setItem('softNav', '1');
        }

        document.addEventListener('click', (event) => {
            const trigger = event.target.closest('[data-soft-nav=\"1\"]');
            if (trigger) {
                enableSoftNav(trigger);
            }
        });

        document.addEventListener('submit', (event) => {
            const trigger = event.target.closest('form[data-soft-nav=\"1\"]');
            if (trigger) {
                enableSoftNav(trigger);
            }
        });

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
