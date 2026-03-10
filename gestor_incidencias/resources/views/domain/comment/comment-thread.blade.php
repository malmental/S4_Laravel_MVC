{{--
    Componente: comment-thread
    Descripción: Componente recursivo para renderizar comentarios anidados.
                  Muestra el comentario, sus respuestas (hijas), y un formulario para responder.
                  Se llama a sí mismo para renderizar respuestas anidadas.
    
    Props:
        - comment: Instancia del modelo Comment (requerido)
        - canDelete: Boolean - si es true, muestra botón de eliminar (default: false)
    
    Uso:
        <x-comment-thread :comment="$comment" :canDelete="true" />
        
    Nota: Este componente se usa recursivamente para comentarios anidados.
          Laravel Blade automáticamentelocaliza componentes en subcarpetas
          como x-domain-comment-comment-thread, o se puede crear un alias.
--}}

@props(['comment', 'canDelete' => false])

{{-- Contenedor principal con sangría左侧 (ml-5) y línea border-left --}}
<div class="ml-5 pl-4 border-l border-gray-300 space-y-3">
    
    {{-- Bloque del comentario: autor, contenido y botón de eliminar --}}
    <div class="p-3 bg-cream border border-gray-300 relative">
        {{-- Botón de eliminar (solo si canDelete es true) --}}
        @if($canDelete)
            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="absolute top-2 right-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs leading-none font-bold text-gray-600 hover:text-red-700" title="Eliminar">&times;</button>
            </form>
        @endif
        
        {{-- Nombre del autor --}}
        <p class="text-xs font-bold pr-5">{{ $comment->user?->name ?? 'Usuario' }}</p>
        
        {{-- Contenido del comentario --}}
        <p class="text-sm mt-1 pr-5">{{ $comment->re }}</p>
    </div>

    {{-- Sección recursiva: renderizar respuestas Hijas (si existen) --}}
    @if($comment->replies->count() > 0)
        <div class="mt-2">
            @foreach($comment->replies as $reply)
                {{-- Llamada recursiva al mismo componente --}}
                <x-comment-thread :comment="$reply" :canDelete="$canDelete" />
            @endforeach
        </div>
    @endif

    {{-- Formulario para responder a este comentario --}}
    <form method="POST" action="{{ route('comments.store') }}" class="space-y-2">
        @csrf
        {{-- ID de la incidencia a la que pertenece el comentario --}}
        <input type="hidden" name="incidencia_id" value="{{ $comment->incidencia_id }}">
        {{-- ID del comentario padre (para respuestas anidadas) --}}
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        
        {{-- Textarea de respuesta --}}
        <textarea
            name="contenido"
            rows="2"
            required
            class="w-full p-2 text-sm bg-cream border border-gray-300 focus:outline-none"
            placeholder="Responder..."
        ></textarea>
        
        {{-- Botón de enviar respuesta --}}
        <button type="submit" class="px-3 py-1 border border-black bg-white text-xs uppercase">
            Responder
        </button>
    </form>
</div>
