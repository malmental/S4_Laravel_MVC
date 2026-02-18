<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Incidencias</title>
</head>
<body>
    <h1>Bienvenido al Gestor de Incidencias</h1>

    @auth
        <p>Hola {{ auth()->user()->name }}!</p>
        <a href="{{ route('incidencias.index') }}">Ver incidencias</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Registrarse</a>
    @endauth
</body>
</html>