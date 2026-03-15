{{-- Contenedor base del comentario y su hilo de respuestas --}}
<div class="ml-5 pl-4 border-l border-gray-300 space-y-3">
    
    {{-- Encabezado del comentario: autor y contenido --}}
    <div class="p-3 bg-cream border border-gray-300">
        <p class="text-xs font-bold">{{ $comment->user->name ?? 'Usuario' }}</p>
        <p class="text-sm mt-1">{{ $comment->contenido }}</p>
    </div>

    {{-- Formulario para responder al comentario actual --}}
    <form method="POST" action="{{ route('comments.store') }}" class="space-y-2">
        @csrf
        <input type="hidden" name="incidencia_id" value="{{ $comment->incidencia_id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea
            name="contenido"
            rows="2"
            required
            class="w-full p-2 text-sm bg-cream border border-gray-300 focus:outline-none"
            placeholder="Responder..."
        ></textarea>
        <button type="submit" class="px-3 py-1 border border-black bg-white text-xs uppercase interactive-btn">
            Responder
        </button>
    </form>

    {{-- Acción de borrado visible solo para comentarios autorizados --}}
    @can('delete', $comment)
        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-1 border border-red-700 bg-red-700 text-white text-xs uppercase interactive-btn">
                Eliminar
            </button>
        </form>
    @endcan

    {{-- Render recursivo de respuestas hijas --}}
    @foreach($comment->replies as $reply)
        @include('comments.comment', ['comment' => $reply])
    @endforeach
</div>
