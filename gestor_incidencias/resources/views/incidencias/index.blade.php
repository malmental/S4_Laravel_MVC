<h1>Incidencias</h1>

<a href="{{ route('incidencias.create') }}">Nueva incidencia</a>

<ul>
@foreach($incidencias as $incidencia)
    <li>
        <strong>{{ $incidencia->titulo }}</strong> - {{ $incidencia->estado }} - {{ $incidencia->prioridad }}
            <br>
                Tags: 
                @foreach($incidencia->tags as $tag)
                    {{ $tag->nombre }},
                @endforeach
            <br>
            <a href="{{ route('incidencias.edit', $incidencia->id) }}">Editar</a>

            <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Borrar</button>
            </form>

        <h4>Comentarios:</h4>
        <ul>
            @foreach($incidencia->comments as $comment)
                <li>{{ $comment->user->name }}: {{ $comment->contenido }}</li>
            @endforeach
        </ul>
    </li>
@endforeach
</ul>