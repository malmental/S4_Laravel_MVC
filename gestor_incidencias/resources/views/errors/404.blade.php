<!DOCTYPE html>
<html lang="es">

<head>
    {{-- SECCIÓN HEAD de Metadatos --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='%23333' d='M15 2a7 7 0 0 0-6.88 5.737a6 6 0 0 1 8.143 8.143A6.997 6.997 0 0 0 15 2'/><circle cx='7' cy='17' r='5' fill='currentColor'/><path d='M11 7a6 6 0 0 0-5.97 5.406a4.997 4.997 0 0 1 6.564 6.564A6 6 0 0 0 11 7' opacity='.5'/></svg>" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --cream: #e8e6e3;
            --cream-dark: #d4d2cf;
        }

        body {
            font-family: 'IBM Plex Mono', monospace;
            background-color: var(--cream);
        }
    </style>
</head>

<body class="bg-cream min-h-screen flex items-center justify-center p-4">

    {{-- Contenedor principal --}}
    <div class="w-full max-w-md">

        {{-- Tarjeta blanca con bordes negros --}}
        <div class="bg-white border-2 border-black">

            {{-- Barra de título --}}
            <div class="px-6 py-4 border-b-2 border-black bg-cream-dark">
                <h1 class="text-lg font-semibold uppercase tracking-tight">Error 404</h1>
            </div>

            {{-- SVG, código 404 y mensaje --}}
            <div class="p-6 text-center">

                {{-- SVG de alerta animado (justo encima del 404) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-16 h-16 mx-auto mb-4 text-red-600">
                    <title xmlns="">alert-square-twotone</title>
                    <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path fill="currentColor" fill-opacity="0" stroke-dasharray="66" d="M12 4h7c0.55 0 1 0.45 1 1v14c0 0.55 -0.45 1 -1 1h-14c-0.55 0 -1 -0.44 -1 -1v-14c0 -0.55 0.45 -1 1 -1Z">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="66;0" />
                            <animate fill="freeze" attributeName="fill-opacity" begin="1s" dur="0.15s" to=".3" />
                        </path>
                        <g fill="none">
                            <path stroke-dasharray="8" stroke-dashoffset="8" d="M12 7v6">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" to="0" />
                            </path>
                            <path stroke-dasharray="4" stroke-dashoffset="4" d="M12 17v0.01">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" to="0" />
                            </path>
                        </g>
                    </g>
                </svg>

                {{-- Código numérico del error --}}
                <div class="text-6xl font-bold mb-4">404</div>

                {{-- Mensaje descriptivo --}}
                <p class="text-gray-700 mb-6">La página que buscas no existe o ha sido movida.</p>

                {{-- Botón volver al inicio --}}
                <a href="{{ url('/') }}" class="inline-block px-6 py-3 border-2 border-black bg-black text-white text-sm uppercase hover:bg-gray-800 transition-colors">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</body>

</html>