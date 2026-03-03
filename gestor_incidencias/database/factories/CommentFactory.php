<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'contenido' => fake()->paragraph(),
            'user_id' => User::factory(),
            'incidencia_id' => Incidencia::factory(),
            'parent_id' => null,
        ];
    }
}