<div style="margin-left: 20px; border-left:1px solid #ccc; padding-left:10px;">

    <p><strong>{{ $comment->user->name }}</strong></p>
    <p>{{ $comment->contenido }}</p>

    @foreach($comment->tags as $tag)
        <span>#{{ $tag->name }}</span>
    @endforeach

    <!-- Responder -->
    <form method="POST" action="{{ route('comments.store') }}">
        @csrf
        <input type="hidden" name="incidencia_id" value="{{ $comment->incidencia_id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="contenido" required></textarea>
        <button type="submit">Responder</button>
    </form>

    <!-- Eliminar -->
    @can('delete', $comment)
        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    @endcan

    <!-- Replies -->
    @foreach($comment->replies as $reply)
        @include('comments.comment', ['comment' => $reply])
    @endforeach

</div>
