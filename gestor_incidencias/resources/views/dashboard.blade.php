<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Gestor de Incidencias</title>
</head>
<body>
    <h1>Bienvenido, {{ auth()->user()->name }}</h1>
    
    <h2>Estadísticas</h2>
    <ul>
        <li>Abiertas: {{ $estadisticas['abiertas'] }}</li>
        <li>En Proceso: {{ $estadisticas['en_proceso'] }}</li>
        <li>Cerradas: {{ $estadisticas['cerradas'] }}</li>
    </ul>

    <p>
        <a href="{{ route('incidencias.index') }}">Mis Incidencias</a>
    </p>

    <h2>Comentarios Recientes</h2>
    @if($comentarios->count() > 0)
        <ul>
            @foreach($comentarios as $comment)
                <li>{{ $comment->contenido }}</li>
            @endforeach
        </ul>
    @else
        <p>No hay comentarios recientes.</p>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>
