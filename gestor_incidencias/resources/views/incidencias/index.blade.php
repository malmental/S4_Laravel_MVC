<h1>Gestor de Incidencias</h1>

<p>Hola, {{ Auth::user()->name }} | 
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>
</p>

<a href="{{ route('incidencias.create') }}">Nueva incidencia</a>

<ul>
@foreach($incidencias as $incidencia)
    <li>
        {{ $incidencia->titulo }} - {{ $incidencia->estado }} - {{ $incidencia->prioridad }}
        <a href="{{ route('incidencias.edit', $incidencia->id) }}">Editar</a>
        <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Borrar</button>
        </form>
    </li>
@endforeach
</ul>
