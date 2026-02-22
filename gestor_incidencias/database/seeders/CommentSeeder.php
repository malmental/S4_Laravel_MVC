<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Incidencia;
use App\Models\Comment;
class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $salem = User::where('email', 'salem@telsur.cl')->first();
        $malmental = User::where('email', 'malmental@telsur.cl')->first();
        $dungeon = User::where('email', 'dungeongoblin@telsur.cl')->first();
        
        // Incidencia 1: Error en el login (Salem)
        $c1 = Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => 1,
            'contenido' => 'Estoy investigando el problema con el equipo de IT.'
        ]);
        
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => 1,
            'parent_id' => $c1->id,
            'contenido' => 'Parece que es cosa de Google, hay outage報告.'
        ]);
        // Incidencia 2: Pantalla azul (Salem)
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => 2,
            'contenido' => 'Necesito más información sobre cuándo ocurre.'
        ]);
        // Incidencia 3: Teclado no funciona (Malo Mentalo)
        $c2 = Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => 3,
            'contenido' => 'Ya pedí teclado nuevo, llega mañana.'
        ]);
        
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => 3,
            'parent_id' => $c2->id,
            'contenido' => 'Gracias por la gestión!'
        ]);
        // Incidencia 4: Internet lento (Malo Mentalo)
        Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => 4,
            'contenido' => '¿Es problema del router o del cableado?'
        ]);
        // Incidencia 5: Error de impresión (Dungeon Goblin)
        Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => 5,
            'contenido' => 'Problema resuelto, era el driver.'
        ]);
        // Incidencia 6: Correo no sincroniza (Dungeon Goblin)
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => 6,
            'contenido' => 'Sincronizado manualmente, funcionando.'
        ]);
    }
}