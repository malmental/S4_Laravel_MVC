<!DOCTYPE html>
<html lang="es">
<head>
    {{-- Metadatos básicos y recursos de estilos --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Incident Manager</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='%23333' d='M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6.997 0 0 0 15 2'/><circle cx='7' cy='17' r='5' fill='currentColor'/><path d='M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7' opacity='.5'/></svg>" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    {{-- Configuración visual de Tailwind para esta vista standalone --}}
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
    
    {{-- Flag de transición entre páginas (misma mecánica que dashboard/incidencias) --}}
    <script>
        window.__softEnter = sessionStorage.getItem('softNav') === '1';
        if (window.__softEnter) {
            document.documentElement.classList.add('soft-enter');
            sessionStorage.removeItem('softNav');
        }
    </script>
    
    {{-- Estilos locales: tipografía + animación de entrada + accesibilidad --}}
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

{{-- Contenedor principal centrado de la pantalla de login --}}
<body class="bg-cream min-h-screen flex items-center justify-center p-6">
    <div class="page-main w-full max-w-md">
        
        {{-- Encabezado de marca e identidad del sistema --}}
        <div class="border-3 border-black bg-cream p-6 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-20 h-20 mb-3" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="7" cy="17" r="5"/>
                    <path d="M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6.997 0 0 0 15 2" opacity=".25"/>
                    <path d="M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7" opacity=".5"/>
                </svg>
                <a href="{{ route('home') }}" data-soft-nav="1" class="hover:text-gray-600">
                    <h1 class="text-3xl font-semibold tracking-tight">INCIDENsly 𝒘ebApp</h1>
                </a>
            </div>
            <p class="text-sm text-gray-custom mt-1">An Incident Manager</p>
        </div>

        {{-- Tarjeta principal de autenticación --}}
        <div class="border-3 border-black bg-white">
            {{-- Cabecera de la tarjeta --}}
            <div class="border-b-2 border-black bg-cream-dark px-6 py-4">
                <h2 class="text-lg font-semibold uppercase tracking-wide">Iniciar Sesión</h2>
            </div>

            {{-- Cuerpo: validación y formulario --}}
            <div class="p-6">
                
                {{-- Bloque de errores de validación --}}
                @if ($errors->any())
                    <div class="border-2 border-black bg-red-50 p-4 mb-6">
                        <div class="text-sm font-medium text-red-900 mb-2">
                            Se encontraron los siguientes errores:
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-800 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulario de login --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5" data-soft-nav="1">
                    @csrf

                    {{-- Campo email --}}
                    <div>
                        <label for="email" class="block text-xs uppercase tracking-wide text-gray-custom font-semibold mb-2">
                            Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border-2 border-black bg-cream-dark focus:bg-white focus:outline-none font-mono text-sm transition-colors"
                            placeholder="usuario@ejemplo.com"
                        >
                    </div>

                    {{-- Campo contraseña --}}
                    <div>
                        <label for="password" class="block text-xs uppercase tracking-wide text-gray-custom font-semibold mb-2">
                            Contraseña
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border-2 border-black bg-cream-dark focus:bg-white focus:outline-none font-mono text-sm transition-colors"
                            placeholder="••••••••"
                        >
                    </div>

                    {{-- Opción recordar sesión --}}
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            type="checkbox" 
                            name="remember"
                            class="w-4 h-4 border-2 border-black bg-cream-dark focus:ring-0 focus:ring-offset-0"
                        >
                        <label for="remember" class="ml-3 text-sm font-medium">
                            Recordarme
                        </label>
                    </div>

                    {{-- Acción principal: iniciar sesión --}}
                    <button 
                        type="submit"
                        class="w-full px-6 py-3 border-2 border-black bg-black text-white font-semibold uppercase tracking-wide text-sm hover:bg-gray-800 transition-colors"
                    >
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- Acceso a registro para usuarios nuevos --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-custom">
                ¿No tienes cuenta? 
                <a 
                    href="{{ route('register') }}" 
                    data-soft-nav="1"
                    class="font-semibold text-black underline hover:no-underline"
                >
                    Registrarse
                </a>
            </p>
        </div>

        {{-- Pie informativo --}}
        <div class="mt-8 text-center text-xs text-gray-custom">
            <p>INCIDENsly 𝒘ebApp &copy; 2026</p>
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
