<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Incident Manager')</title>
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
<body class="bg-cream min-h-screen">
    <div class="max-w-7xl mx-auto p-6">
        
        <!-- Header -->
        <div class="border-3 border-black bg-white mb-6">
            <div class="px-6 py-4 flex items-center justify-between border-b-2 border-black">
                <h1 class="text-2xl font-semibold tracking-tight">INCIDENT MANAGER</h1>
                <div class="text-right text-xs">
                    <div id="headerTime">v2.1 | --</div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-cream-dark text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-black rounded-full"></span>
                <span class="font-semibold">SYSTEM ONLINE</span>
            </div>

            <!-- En el layout, línea 49-58, reemplazar el div de botones -->
            <div class="flex items-center gap-4">
                <span>USER: {{ strtoupper(auth()->user()->name ?? 'ADMIN') }}</span>
                    <a href="{{ route('incidencias.index') }}" class="px-4 py-1 border border-black     bg-black text-white text-xs uppercase hover:bg-gray-800">
                    My Incidents
                    </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-8 py-1 border border-black bg-white text-xs uppercase hover:bg-gray-200">
                    Logout
                    </button>
                </form>
                
                <form method="POST" action="{{ route('profile.destroy') }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar tu usuario?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 border border-red-600 bg-red-600 text-white text-xs uppercase hover:bg-red-700">
                    Destroy User
                    </button>
                </form>
            </div>
        </div>
    
    </div>
        <!-- Main Layout -->
        @yield('content')
    </div>

<script>
    function updateTime() {
        const now = new Date();
        const formatted = now.getFullYear() + '.' + 
                        String(now.getMonth() + 1).padStart(2, '0') + '.' + 
                        String(now.getDate()).padStart(2, '0') + ' ' +
                        String(now.getHours()).padStart(2, '0') + ':' +
                        String(now.getMinutes()).padStart(2, '0');
        const timeEl = document.getElementById('headerTime');
        if (timeEl) {
            timeEl.textContent = 'v2.1 | ' + formatted;
        }
    }
    setInterval(updateTime, 60000);
    updateTime();
</script>

</body>
</html>