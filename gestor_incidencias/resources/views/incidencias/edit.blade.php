<h1>Editar Incidencia</h1>

<form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Título:</label>
    <input type="text" name="titulo" value="{{ $incidencia->titulo }}"><br>

    <label>Descripción:</label>
    <textarea name="descripcion">{{ $incidencia->descripcion }}</textarea><br>

    <label>Estado:</label>
    <select name="estado">
        <option value="abierta" {{ $incidencia->estado == 'abierta' ? 'selected' : '' }}>Abierta</option>
        <option value="en_proceso" {{ $incidencia->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
        <option value="cerrada" {{ $incidencia->estado == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
    </select><br>

    <label>Prioridad:</label>
    <select name="prioridad">
        <option value="baja" {{ $incidencia->prioridad == 'baja' ? 'selected' : '' }}>Baja</option>
        <option value="media" {{ $incidencia->prioridad == 'media' ? 'selected' : '' }}>Media</option>
        <option value="alta" {{ $incidencia->prioridad == 'alta' ? 'selected' : '' }}>Alta</option>
    </select><br>

    <label>Tags (IDs separados por coma):</label>
    <input type="text" name="tags" value="{{ implode(',', $incidencia->tags->pluck('id')->toArray()) }}"><br>

    <button type="submit">Actualizar</button>
</form>