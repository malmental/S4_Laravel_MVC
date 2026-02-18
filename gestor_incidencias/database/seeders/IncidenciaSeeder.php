<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Incidencia;

class IncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        // --- USUARIO 1: Salem ---
        $user = User::firstOrCreate(
            ['email' => 'salem@telsur.cl'],
            ['name' => 'Salem', 'password' => bcrypt('password')]
        );

        Incidencia::create([
            'titulo' => 'Error en el login',
            'descripcion' => 'No puedo entrar con mi cuenta de Google',
            'estado' => 'en_proceso',
            'user_id' => $user->id
        ]);

        Incidencia::create([
            'titulo' => 'Pantalla azul',
            'descripcion' => 'Al abrir el panel de control explota todo',
            'estado' => 'en_proceso',
            'user_id' => $user->id
        ]);

        // --- USUARIO 2: Malo Mentalo ---
        $user2 = User::firstOrCreate(
            ['email' => 'malmental@telsur.cl.com'], 
            ['name' => 'Malo Mentalo', 'password' => bcrypt('password')]
        );

        Incidencia::create([
            'titulo' => 'Teclado no funciona',
            'descripcion' => 'Se derramó café y la tecla Enter no responde',
            'estado' => 'abierta',
            'user_id' => $user2->id
        ]);

        Incidencia::create([
            'titulo' => 'Internet lento',
            'descripcion' => 'En la oficina del fondo no llega el WiFi',
            'estado' => 'abierta',
            'user_id' => $user2->id
        ]);

        // --- USUARIO 3: Dungeon Goblin ---
        $user3 = User::firstOrCreate(
            ['email' => 'dungeongoblin@telsur.cl'], 
            ['name' => 'Dungeon Goblin', 'password' => bcrypt('password')]
        );

        Incidencia::create([
            'titulo' => 'Error de impresión',
            'descripcion' => 'La impresora no imprime correctamente',
            'estado' => 'cerrada',
            'user_id' => $user3->id
        ]);

        Incidencia::create([
            'titulo' => 'Correo no sincroniza',
            'descripcion' => 'Mi correo no se actualiza con los nuevos mensajes',
            'estado' => 'cerrada',
            'user_id' => $user3->id
        ]);
    }
}