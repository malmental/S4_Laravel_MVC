<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Solo llamas al otro seeder aquí
        $this->call([
            UserSeeder::class,
            // IncidenciaSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}