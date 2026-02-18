<!DOCTYPE html>
<html>
<head>
    <title>Editar Incidencia</title>
</head>
<body>
    <h1>Editar Incidencia</h1>

    <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Título:</label><br>
        <input type="text" name="titulo" value="{{ old('titulo', $incidencia->titulo) }}" required>
        @error('titulo') <span>{{ $message }}</span> @enderror<br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required>{{ old('descripcion', $incidencia->descripcion) }}</textarea>
        @error('descripcion') <span>{{ $message }}</span> @enderror<br><br>

        <label>Estado:</label><br>
        <select name="estado">
            <option value="abierta" {{ old('estado', $incidencia->estado)=='abierta' ? 'selected' : '' }}>Abierta</option>
            <option value="en_proceso" {{ old('estado', $incidencia->estado)=='en_proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="cerrada" {{ old('estado', $incidencia->estado)=='cerrada' ? 'selected' : '' }}>Cerrada</option>
        </select><br><br>

        <label>Prioridad:</label><br>
        <select name="prioridad">
            <option value="baja" {{ old('prioridad', $incidencia->prioridad)=='baja' ? 'selected' : '' }}>Baja</option>
            <option value="media" {{ old('prioridad', $incidencia->prioridad)=='media' ? 'selected' : '' }}>Media</option>
            <option value="alta" {{ old('prioridad', $incidencia->prioridad)=='alta' ? 'selected' : '' }}>Alta</option>
        </select><br><br>

        <button type="submit">Actualizar Incidencia</button>
    </form>

    <a href="{{ route('incidencias.index') }}">Volver</a>
</body>
</html>
