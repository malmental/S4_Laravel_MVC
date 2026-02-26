<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Incidencia;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\HasTags;
use App\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
    use HasTags;

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(CommentStoreRequest $request)
    {
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'incidencia_id' => $request->incidencia_id,
            'parent_id' => $request->parent_id,
            'contenido' => $request->contenido,
        ]);
        $this->syncTags($comment, $request->tags);
        return back();
    }

    public function show(Comment $comment)
    {
        //
    }

    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back();
    }
}