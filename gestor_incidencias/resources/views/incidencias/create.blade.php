@extends('layouts.app')
@section('title', 'Nueva Incidencia')

@section('content')

<div class="bg-white max-w-3xl mx-auto">
    
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Nueva Incidencia</h2>
    </div>

    <div class="p-6">
        <x-domain-incidence-form action="{{ route('incidencias.store') }}" submitText="Crear incidencia">
            <a href="{{ route('incidencias.index') }}" data-soft-nav="1" class="px-5 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                Cancelar
            </a>
            <button type="submit" class="px-5 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                Crear incidencia
            </button>
        </x-domain-incidence-form>
    </div>
</div>
@endsection