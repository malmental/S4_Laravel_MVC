<!DOCTYPE html>
<html>
<head>
    <title>Mis Incidencias</title>
</head>
<body>
    <h1>Mis Incidencias</h1>

    <a href="{{ route('incidencias.create') }}">Nueva Incidencia</a>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Título</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidencias as $incidencia)
            <tr>
                <td>{{ $incidencia->titulo }}</td>
                <td>{{ $incidencia->estado }}</td>
                <td>{{ $incidencia->prioridad }}</td>
                <td>
                    <a href="{{ route('incidencias.edit', $incidencia->id) }}">Editar</a>
                    <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No hay incidencias.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}">Volver al Dashboard</a>
</body>
</html>
