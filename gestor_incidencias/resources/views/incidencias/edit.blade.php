<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Incidencia</title>
</head>
<body>
    <h1>Editar Incidencia</h1>

    <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>Título:</label><br>
            <input type="text" name="titulo" value="{{ old('titulo', $incidencia->titulo) }}">
            @error('titulo') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Descripción:</label><br>
            <textarea name="descripcion">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
            @error('descripcion') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Estado:</label><br>
            <select name="estado">
                <option value="abierta" {{ old('estado', $incidencia->estado)=='abierta' ? 'selected' : '' }}>Abierta</option>
                <option value="en_proceso" {{ old('estado', $incidencia->estado)=='en_proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="cerrada" {{ old('estado', $incidencia->estado)=='cerrada' ? 'selected' : '' }}>Cerrada</option>
            </select>
            @error('estado') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Prioridad:</label><br>
            <select name="prioridad">
                <option value="baja" {{ old('prioridad', $incidencia->prioridad)=='baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('prioridad', $incidencia->prioridad)=='media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('prioridad', $incidencia->prioridad)=='alta' ? 'selected' : '' }}>Alta</option>
            </select>
            @error('prioridad') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <button type="submit">Actualizar Incidencia</button>
    </form>

    <a href="{{ route('incidencias.index') }}">Volver al listado</a>
</body>
</html>
