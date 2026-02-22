<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Incident Manager</title>
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
<body class="bg-cream min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-2xl">
        <!-- Main Card -->
        <div class="border-3 border-black bg-white">
            <!-- Header -->
            <div class="border-b-2 border-black bg-cream-dark px-8 py-6">
                <h1 class="text-3xl font-semibold tracking-tight text-center">INCIDENT MANAGER</h1>
                <p class="text-sm text-gray-custom text-center mt-2">Sistema de Gestión de Incidencias v2.1</p>
            </div>

            <!-- Body -->
            <div class="p-8">
                @auth
                    <!-- Authenticated User View -->
                    <div class="text-center mb-8">
                        <div class="border-2 border-black bg-cream-dark p-6 mb-6">
                            <p class="text-lg mb-2">Bienvenido,</p>
                            <p class="text-2xl font-semibold">{{ auth()->user()->name }}</p>
                        </div>

                        <p class="text-sm text-gray-custom mb-8">
                            Has iniciado sesión correctamente. Accede al panel de incidencias para comenzar.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <a 
                            href="{{ route('incidencias.index') }}"
                            class="block w-full px-6 py-4 border-2 border-black bg-black text-white font-semibold uppercase tracking-wide text-sm text-center hover:bg-gray-800 transition-colors"
                        >
                            Ver Incidencias
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
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
                    <!-- Guest View -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-semibold mb-4">Bienvenido al Sistema</h2>
                        <p class="text-sm text-gray-custom leading-relaxed">
                            Sistema profesional de gestión y seguimiento de incidencias.<br>
                            Organiza, asigna y resuelve problemas de manera eficiente.
                        </p>
                    </div>

                    <!-- Features -->
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

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-4">
                        <a 
                            href="{{ route('login') }}"
                            class="px-6 py-4 border-2 border-black bg-black text-white font-semibold uppercase tracking-wide text-sm text-center hover:bg-gray-800 transition-colors"
                        >
                            Iniciar Sesión
                        </a>

                        <a 
                            href="{{ route('register') }}"
                            class="px-6 py-4 border-2 border-black bg-cream-dark font-semibold uppercase tracking-wide text-sm text-center hover:bg-gray-custom hover:text-white transition-colors"
                        >
                            Registrarse
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Footer Info -->
            <div class="border-t-2 border-black bg-cream-dark px-8 py-4">
                <div class="flex items-center justify-between text-xs text-gray-custom">
                    <span>Incident Manager &copy; 2026</span>
                    <span>Version 2.1.0</span>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center text-xs text-gray-custom">
            <p>Sistema desarrollado para la gestión eficiente de incidencias</p>
        </div>
    </div>
</body>
</html>