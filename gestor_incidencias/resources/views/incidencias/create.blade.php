<!DOCTYPE html>
<html>
<head>
    <title>Nueva Incidencia</title>
</head>
<body>
    <h1>Nueva Incidencia</h1>

    <form action="{{ route('incidencias.store') }}" method="POST">
        @csrf
        <label>Título:</label><br>
        <input type="text" name="titulo" value="{{ old('titulo') }}" required>
        @error('titulo') <span>{{ $message }}</span> @enderror<br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required>{{ old('descripcion') }}</textarea>
        @error('descripcion') <span>{{ $message }}</span> @enderror<br><br>

        <label>Estado:</label><br>
        <select name="estado">
            <option value="abierta">Abierta</option>
            <option value="en_proceso">En proceso</option>
            <option value="cerrada">Cerrada</option>
        </select><br><br>

        <label>Prioridad:</label><br>
        <select name="prioridad">
            <option value="baja">Baja</option>
            <option value="media" selected>Media</option>
            <option value="alta">Alta</option>
        </select><br><br>

        <button type="submit">Crear Incidencia</button>
    </form>

    <a href="{{ route('incidencias.index') }}">Volver</a>
</body>
</html>
