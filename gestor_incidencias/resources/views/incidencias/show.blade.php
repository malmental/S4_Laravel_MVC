<!DOCTYPE html>
<html>
<head>
    <title>Ver Incidencia</title>
</head>
<body>
    <h1>Detalle de Incidencia</h1>

    <p><strong>Título:</strong> {{ $incidencia->titulo }}</p>
    <p><strong>Descripción:</strong> {{ $incidencia->descripcion }}</p>
    <p><strong>Estado:</strong> {{ $incidencia->estado }}</p>
    <p><strong>Prioridad:</strong> {{ $incidencia->prioridad }}</p>
    <p><strong>Creada:</strong> {{ $incidencia->created_at }}</p>

    <a href="{{ route('incidencias.edit', $incidencia->id) }}">Editar</a> |
    <a href="{{ route('incidencias.index') }}">Volver</a>
</body>
</html>
