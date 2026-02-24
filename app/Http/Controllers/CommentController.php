<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string',
            'incidencia_id' => 'required|exists:incidencias,id',
            'parent_id' => 'nullable|exists:comments,id',
            'tags' => 'nullable|string'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'incidencia_id' => $request->incidencia_id,
            'parent_id' => $request->parent_id,
            'contenido' => $request->contenido,
        ]);

        // Procesar hashtags
        if ($request->tags) {
            preg_match_all('/#(\w+)/', $request->tags, $matches);

            foreach ($matches[1] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => strtolower($tagName)]);
                $comment->tags()->attach($tag->id);
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back();
    }
}
