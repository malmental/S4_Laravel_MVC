<?php

use App\Models\Incidencia;
use App\Models\Comment;
use App\Models\User;

public function run()
{
    $user = User::first();
    $incidencia = Incidencia::first();

    // Comentario raíz
    $comment1 = Comment::create([
        'incidencia_id' => $incidencia->id,
        'user_id' => $user->id,
        'content' => 'Este es un comentario principal #bug #urgente',
        'parent_id' => null,
    ]);

    // Respuestas al comentario raíz
    Comment::create([
        'incidencia_id' => $incidencia->id,
        'user_id' => $user->id,
        'content' => 'Respuesta al comentario principal #frontend',
        'parent_id' => $comment1->id,
    ]);

    Comment::create([
        'incidencia_id' => $incidencia->id,
        'user_id' => $user->id,
        'content' => 'Otra respuesta anidada #backend',
        'parent_id' => $comment1->id,
    ]);

    // Segundo comentario raíz
    $comment2 = Comment::create([
        'incidencia_id' => $incidencia->id,
        'user_id' => $user->id,
        'content' => 'Otro comentario independiente #feature',
        'parent_id' => null,
    ]);

    Comment::create([
        'incidencia_id' => $incidencia->id,
        'user_id' => $user->id,
        'content' => 'Respuesta a segundo comentario #ui',
        'parent_id' => $comment2->id,
    ]);
}
