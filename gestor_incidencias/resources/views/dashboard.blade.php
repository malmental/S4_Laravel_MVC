@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Incidencias</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <a href="{{ route('incidencias.create') }}">Crear nueva incidencia</a>

    <ul>
        @forelse(auth()->user()->incidencias as $incidencia)
            <li>
                <strong>{{ $incidencia->titulo }}</strong> -
                Estado: {{ $incidencia->estado }} -
                Prioridad: {{ $incidencia->prioridad }}
            </li>
        @empty
            <li>No tienes incidencias todavía.</li>
        @endforelse
    </ul>
</div>
@endsection
