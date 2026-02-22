<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Incident Manager')</title>
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
<body class="bg-cream min-h-screen">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="border-3 border-black bg-white mb-6">
            <div class="px-6 py-4 flex items-center justify-between border-b-2 border-black">
                <h1 class="text-2xl font-semibold tracking-tight">INCIDENT MANAGER</h1>
                <div class="text-right text-xs">
                    <div>v2.1 | {{ date('Y.m.d H:i') }}</div>
                </div>
            </div>
            <div class="px-6 py-3 bg-cream-dark text-xs flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-black rounded-full"></span>
                <span>SYSTEM ONLINE</span>
                <span class="ml-4">USER: {{ strtoupper(auth()->user()->name ?? 'ADMIN') }}</span>
            </div>
        </div>
        <!-- Main -->
        @yield('content')
    </div>
</body>
</html>