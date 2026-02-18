<h1>Nueva Incidencia</h1>

<form action="{{ route('incidencias.store') }}" method="POST">
    @csrf
    <label>Título:</label>
    <input type="text" name="titulo"><br>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea><br>

    <label>Estado:</label>
    <select name="estado">
        <option value="abierta">Abierta</option>
        <option value="en_proceso">En proceso</option>
        <option value="cerrada">Cerrada</option>
    </select><br>

    <label>Prioridad:</label>
    <select name="prioridad">
        <option value="baja">Baja</option>
        <option value="media">Media</option>
        <option value="alta">Alta</option>
    </select><br>

    <label>Tags (IDs separados por coma):</label>
    <input type="text" name="tags"><br>

    <button type="submit">Crear</button>
</form>