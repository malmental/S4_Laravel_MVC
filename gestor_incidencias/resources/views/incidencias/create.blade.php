<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Incidencia</title>
</head>
<body>
    <h1>Crear nueva Incidencia</h1>

    <form action="{{ route('incidencias.store') }}" method="POST">
        @csrf
        <p>
            <label>Título:</label><br>
            <input type="text" name="titulo" value="{{ old('titulo') }}">
            @error('titulo') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Descripción:</label><br>
            <textarea name="descripcion">{{ old('descripcion') }}</textarea>
            @error('descripcion') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Estado:</label><br>
            <select name="estado">
                <option value="abierta" {{ old('estado')=='abierta' ? 'selected' : '' }}>Abierta</option>
                <option value="en_proceso" {{ old('estado')=='en_proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="cerrada" {{ old('estado')=='cerrada' ? 'selected' : '' }}>Cerrada</option>
            </select>
            @error('estado') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Prioridad:</label><br>
            <select name="prioridad">
                <option value="baja" {{ old('prioridad')=='baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('prioridad')=='media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('prioridad')=='alta' ? 'selected' : '' }}>Alta</option>
            </select>
            @error('prioridad') <span style="color:red">{{ $message }}</span> @enderror
        </p>

        <button type="submit">Crear Incidencia</button>
    </form>

    <a href="{{ route('incidencias.index') }}">Volver al listado</a>
</body>
</html>
