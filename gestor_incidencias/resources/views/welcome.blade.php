<!DOCTYPE html>
<html lang="es">
<head>
    {{-- Metadatos básicos y recursos visuales de la pantalla de bienvenida --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Incident Manager</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='%23333' d='M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6.997 0 0 0 15 2'/><circle cx='7' cy='17' r='5' fill='currentColor'/><path d='M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7' opacity='.5'/></svg>" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    {{-- Configuración de paleta/tipografías en Tailwind para vista standalone --}}
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
    
    {{-- Flag de transición entre vistas usando sessionStorage (softNav) --}}
    <script>
        window.__softEnter = sessionStorage.getItem('softNav') === '1';
        if (window.__softEnter) {
            document.documentElement.classList.add('soft-enter');
            sessionStorage.removeItem('softNav');
        }
    </script>
    
    {{-- Estilos locales: tipografía base, transición de entrada y accesibilidad --}}
    <style>
        body {
            font-family: 'IBM Plex Mono', monospace;
        }
        .soft-enter .page-main {
            opacity: 0.86;
            transform: translateX(14px) scale(0.998);
            box-shadow: -18px 0 28px rgba(0, 0, 0, 0.08);
            filter: saturate(0.94);
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
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

{{-- Contenedor principal de la landing/welcome --}}
<body class="bg-cream min-h-screen flex items-center justify-center p-6">
    <div class="page-main w-full max-w-2xl">
        
        {{-- Tarjeta principal de contenido --}}
        <div class="border-3 border-black bg-white">
            
            {{-- Cabecera de marca y subtítulo --}}
            <div class="border-b-2 border-black bg-cream-dark px-8 py-6">
                <div class="flex flex-col items-center">

                        <svg class="w-20 h-20 mb-3" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="7" cy="17" r="5"/>
                        <path d="M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6.997 0 0 0 15 2" opacity=".25"/>
                        <path d="M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7" opacity=".5"/>
                        </svg>
                        
                    <h1 class="text-3xl font-semibold tracking-tight">INCIDENsly 𝒘ebApp</h1>
                </div>
                <p class="text-sm text-gray-custom text-center mt-2">Incident Managment</p>
            </div>

            {{-- Cuerpo principal con ramas para usuario autenticado/invitado --}}
            <div class="p-8">
                @auth
                    
                    {{-- Vista para usuario autenticado --}}
                    <div class="text-center mb-8">
                        <div class="border-2 border-black bg-cream-dark p-6 mb-6">
                            <p class="text-lg mb-2">Bienvenido,</p>
                            <p class="text-2xl font-semibold">{{ auth()->user()->name }}</p>
                        </div>

                        <p class="text-sm text-gray-custom mb-8">
                            Has iniciado sesión correctamente. Accede al panel de incidencias para comenzar.
                        </p>
                    </div>

                    {{-- Acciones disponibles para usuario autenticado --}}
                    <div class="space-y-4">
                        <a 
                            href="{{ route('incidencias.index') }}"
                            data-soft-nav="1"
                            class="block w-full px-6 py-4 border-2 border-black bg-black text-white font-semibold uppercase tracking-wide text-sm text-center hover:bg-gray-800 transition-colors"
                        >
                            Ver Incidencias
                        </a>

                        <form action="{{ route('logout') }}" method="POST" data-soft-nav="1">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full px-6 py-4 border-2 border-black bg-cream-dark font-semibold uppercase tracking-wide text-sm hover:bg-gray-custom hover:text-white transition-colors"
                            >
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Vista para usuario invitado --}}
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-semibold mb-4">Bienvenido al Sistema</h2>
                        <p class="text-sm text-gray-custom leading-relaxed">
                            Sistema profesional de gestión y seguimiento de incidencias.<br>
                            Organiza, asigna y resuelve problemas de manera eficiente.
                        </p>
                    </div>

                    {{-- Bloque informativo de características del sistema --}}
                    <div class="border-2 border-black bg-cream p-6 mb-8">
                        <h3 class="text-sm uppercase tracking-wide font-semibold mb-4 text-gray-custom">Características</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-start">
                                <span class="mr-2">▸</span>
                                <span>Gestión completa de incidencias</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">▸</span>
                                <span>Asignación y seguimiento de tareas</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">▸</span>
                                <span>Priorización automática</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">▸</span>
                                <span>Reportes y estadísticas</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Acciones principales para invitado: login/registro --}}
                    <div class="grid grid-cols-2 gap-4">
                        <a 
                            href="{{ route('login') }}"
                            data-soft-nav="1"
                            class="px-6 py-4 border-2 border-black bg-black text-white font-semibold uppercase tracking-wide text-sm text-center hover:bg-gray-800 transition-colors"
                        >
                            Iniciar Sesión
                        </a>

                        <a 
                            href="{{ route('register') }}"
                            data-soft-nav="1"
                            class="px-6 py-4 border-2 border-black bg-cream-dark font-semibold uppercase tracking-wide text-sm text-center hover:bg-gray-custom hover:text-white transition-colors"
                        >
                            Registrarse
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Pie de tarjeta con metadatos de versión --}}
            <div class="border-t-2 border-black bg-cream-dark px-8 py-4">
                <div class="flex items-center justify-between text-xs text-gray-custom">
                    <span>Incident Manager &copy; 2026</span>
                    <span>Version 2.1.0</span>
                </div>
            </div>
        </div>

        {{-- Pie complementario fuera de la tarjeta --}}
        <div class="mt-6 text-center text-xs text-gray-custom">
            <p>Sistema desarrollado para la gestión eficiente de incidencias</p>
        </div>
    </div>
    <script>
        function enableSoftNav(trigger) {
            if (!trigger) {
                return;
            }
            sessionStorage.setItem('softNav', '1');
        }

        document.addEventListener('click', (event) => {
            const trigger = event.target.closest('[data-soft-nav="1"]');
            if (trigger) {
                enableSoftNav(trigger);
            }
        });

        document.addEventListener('submit', (event) => {
            const trigger = event.target.closest('form[data-soft-nav="1"]');
            if (trigger) {
                enableSoftNav(trigger);
            }
        });
    </script>
</body>
</html>
