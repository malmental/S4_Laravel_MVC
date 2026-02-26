@extends('layouts.app')
@section('title', 'Mis Incidencias')
@section('content')

<div class="border-3 border-black bg-white">

    <div class="px-6 py-4 border-b-2 border-black bg-cream-dark flex justify-between items-center">
        <h2 class="text-lg font-semibold uppercase tracking-wide">Mis Incidencias</h2>
        <a href="{{ route('incidencias.create') }}" class="px-4 py-2 border-2 border-black bg-black text-white text-xs uppercase hover:bg-gray-800">
            + Nueva Incidencia
        </a>
    </div>

    <div class="divide-y divide-gray-300">
        @forelse($incidencias as $incidencia)
        <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-cream-dark items-center">
            <div class="col-span-1 font-semibold">INC-{{ str_pad($incidencia->id, 3, '0', STR_PAD_LEFT) }}</div>
            
            <div class="col-span-4">
                <div class="font-medium">{{ $incidencia->titulo }}</div>
                <div class="text-xs text-gray-500">{{ Str::limit($incidencia->descripcion, 50) }}</div>
            </div>

            <div class="col-span-2">
                <span class="px-2 py-1 border-2 border-black text-xs uppercase {{ $incidencia->prioridad === 'alta' ? 'bg-black text-white' : 'bg-white' }}">
                    {{ $incidencia->prioridad }}
                </span>
            </div>

            <div class="col-span-2">
                <span class="px-2 py-1 border-2 border-black text-xs uppercase bg-white">
                    {{ $incidencia->estado }}
                </span>
            </div>

            <div class="col-span-3 flex gap-2 justify-end">
                <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="px-4 py-2 border-2 border-black bg-white text-xs hover:bg-cream-dark">Editar</a>
                <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 border-2 border-black bg-black text-white text-xs hover:bg-gray-800" onclick="return confirm('¿Eliminar?')">X</button>
                </form>
            </div>
        </div>

        @empty
        <div class="px-6 py-8 text-center">No hay incidencias.</div>
        @endforelse
        
        <div class="px-6 py-4 border-t-2 border-black bg-cream-dark">
            {{ $incidencias->links() }}
        </div>

    </div>
    
    <div class="px-6 py-4 border-t-2 border-black bg-cream-dark">
        <a href="{{ route('dashboard') }}" class="text-sm underline">← Volver al Dashboard</a>
    </div>
</div>
@endsection