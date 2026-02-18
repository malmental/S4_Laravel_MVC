<!DOCTYPE html>
<html>
<head>
    <title>Métricas</title>
</head>
<body>
    <h1>Métricas de Incidencias</h1>
    
    <p>Total: {{ $incidencias->count() }}</p>
    <p>Abiertas: {{ $incidencias->where('estado', 'abierta')->count() }}</p>
    <p>En proceso: {{ $incidencias->where('estado', 'en_proceso')->count() }}</p>
    <p>Cerradas: {{ $incidencias->where('estado', 'cerrada')->count() }}</p>

    <p>
        <a href="{{ route('dashboard') }}">Volver al Dashboard</a>
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>
