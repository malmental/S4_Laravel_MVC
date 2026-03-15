<?php

namespace Database\Factories;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidenciaFactory extends Factory
{
    protected $model = Incidencia::class;

    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(3),
            'descripcion' => fake()->paragraph(),
            'estado' => fake()->randomElement(['abierta', 'en_proceso', 'cerrada']),
            'prioridad' => fake()->randomElement(['baja', 'media', 'alta']),
            'user_id' => User::factory(),
        ];
    }
}
