@extends('layouts.app')
@section('title', 'Editar Incidencia')

@section('content')
<div class="bg-white max-w-3xl mx-auto">
    
    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Editar Incidencia</h2>
    </div>

    <div class="p-6">
        <x-domain-incidence-form 
            method="PUT" 
            action="{{ route('incidencias.update', $incidencia->id) }}" 
            :incidencia="$incidencia"
            submitText="Actualizar"
        >
            <a href="{{ route('incidencias.index') }}" data-soft-nav="1" class="px-5 py-2 border-2 border-black bg-white text-xs uppercase interactive-btn">
                Cancelar
            </a>
            <button type="submit" class="px-5 py-2 border-2 border-black bg-black text-white text-xs uppercase interactive-btn">
                Actualizar incidencia
            </button>
        </x-domain-incidence-form>
    </div>
</div>
@endsection