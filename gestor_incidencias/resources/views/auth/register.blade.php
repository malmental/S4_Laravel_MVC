<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Incident Manager</title>
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
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="border-3 border-black bg-cream p-6 mb-6 text-center">
            <h1 class="text-2xl font-semibold tracking-tight">INCIDENT MANAGER</h1>
            <p class="text-sm text-gray-custom mt-1">Sistema de Gestión de Incidencias</p>
        </div>

        <!-- Register Card -->
        <div class="border-3 border-black bg-white">
            <!-- Card Header -->
            <div class="border-b-2 border-black bg-cream-dark px-6 py-4">
                <h2 class="text-lg font-semibold uppercase tracking-wide">Registro de Usuario</h2>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <!-- Errors -->
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

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs uppercase tracking-wide text-gray-custom font-semibold mb-2">
                            Nombre
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border-2 border-black bg-cream-dark focus:bg-white focus:outline-none font-mono text-sm transition-colors"
                            placeholder="Juan Pérez"
                        >
                    </div>

                    <!-- Email Field -->
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
                            class="w-full px-4 py-3 border-2 border-black bg-cream-dark focus:bg-white focus:outline-none font-mono text-sm transition-colors"
                            placeholder="usuario@ejemplo.com"
                        >
                    </div>

                    <!-- Password Field -->
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

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="block text-xs uppercase tracking-wide text-gray-custom font-semibold mb-2">
                            Confirmar Contraseña
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-3 border-2 border-black bg-cream-dark focus:bg-white focus:outline-none font-mono text-sm transition-colors"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full px-6 py-3 border-2 border-black bg-black text-white font-semibold uppercase tracking-wide text-sm hover:bg-gray-800 transition-colors"
                    >
                        Registrarse
                    </button>
                </form>
            </div>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-custom">
                ¿Ya tienes cuenta? 
                <a 
                    href="{{ route('login') }}" 
                    class="font-semibold text-black underline hover:no-underline"
                >
                    Iniciar sesión
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-xs text-gray-custom">
            <p>Incident Manager v2.1 &copy; 2026</p>
        </div>
    </div>
</body>
</html>