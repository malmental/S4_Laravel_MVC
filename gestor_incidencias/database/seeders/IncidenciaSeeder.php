<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Incidencia;

class IncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuarios
        $salem = User::firstOrCreate(
            ['email' => 'salem@telsur.cl'],
            ['name' => 'Salem', 'password' => bcrypt('password')]
        );
        
        $malmental = User::firstOrCreate(
            ['email' => 'malmental@telsur.cl'],
            ['name' => 'Malo Mentalo', 'password' => bcrypt('password')]
        );
        
        $dungeon = User::firstOrCreate(
            ['email' => 'dungeongoblin@telsur.cl'],
            ['name' => 'Dungeon Goblin', 'password' => bcrypt('password')]
        );
        
        // Incidencia 1 - Salem
        Incidencia::create([
            'titulo' => 'Error en el login',
            'descripcion' => 'No puedo entrar con mi cuenta de Google',
            'estado' => 'en_proceso',
            'prioridad' => 'alta',
            'user_id' => $salem->id
        ]);
        
        // Incidencia 2 - Salem
        Incidencia::create([
            'titulo' => 'Pantalla azul',
            'descripcion' => 'Al abrir el panel de control explota todo',
            'estado' => 'en_proceso',
            'prioridad' => 'media',
            'user_id' => $salem->id
        ]);
        
        // Incidencia 3 - Malo Mentalo
        Incidencia::create([
            'titulo' => 'Teclado no funciona',
            'descripcion' => 'Se derramó café y la tecla Enter no responde',
            'estado' => 'abierta',
            'prioridad' => 'alta',
            'user_id' => $malmental->id
        ]);
        // Incidencia 4 - Malo Mentalo
        Incidencia::create([
            'titulo' => 'Internet lento',
            'descripcion' => 'En la oficina del fondo no llega el WiFi',
            'estado' => 'abierta',
            'prioridad' => 'baja',
            'user_id' => $malmental->id
        ]);
        // Incidencia 5 - Dungeon Goblin
        Incidencia::create([
            'titulo' => 'Error de impresión',
            'descripcion' => 'La impresora no imprime correctamente',
            'estado' => 'cerrada',
            'prioridad' => 'alta',
            'user_id' => $dungeon->id
        ]);
        
        // Incidencia 6 - Dungeon Goblin
        Incidencia::create([
            'titulo' => 'Correo no sincroniza',
            'descripcion' => 'Mi correo no se actualiza con los nuevos mensajes',
            'estado' => 'cerrada',
            'prioridad' => 'baja',
            'user_id' => $dungeon->id
        ]);
        
        // Incidencia 7 - Salem
        Incidencia::create([
            'titulo' => 'No enciende el PC',
            'descripcion' => 'Al presionar el botón de inicio no responde',
            'estado' => 'abierta',
            'prioridad' => 'alta',
            'user_id' => $salem->id
        ]);
        
        // Incidencia 8 - Malo Mentalo
        Incidencia::create([
            'titulo' => 'WiFi no conecta',
            'descripcion' => 'El portátil no se conecta a la red WiFi de la oficina',
            'estado' => 'en_proceso',
            'prioridad' => 'media',
            'user_id' => $malmental->id
        ]);
        
        // Incidencia 9 - Dungeon Goblin
        Incidencia::create([
            'titulo' => 'Aplicación no responde',
            'descripcion' => 'El software de gestión se queda colgado frecuentemente',
            'estado' => 'cerrada',
            'prioridad' => 'media',
            'user_id' => $dungeon->id
        ]);
        // Incidencia 10 - Salem
        Incidencia::create([
            'titulo' => 'Contraseña expirada',
            'descripcion' => 'No puedo acceder al sistema, me dice que la contraseña expiró',
            'estado' => 'abierta',
            'prioridad' => 'alta',
            'user_id' => $salem->id
        ]);
        
        // Incidencia 11 - Malo Mentalo
        Incidencia::create([
            'titulo' => 'Impresora atascada',
            'descripcion' => 'El papel se atasca al intentar imprimir documentos grandes',
            'estado' => 'en_proceso',
            'prioridad' => 'baja',
            'user_id' => $malmental->id
        ]);
        
        // Incidencia 12 - Dungeon Goblin
        Incidencia::create([
            'titulo' => 'Antivirus desactualizado',
            'descripcion' => 'El sistema antivirus no se actualiza automáticamente',
            'estado' => 'cerrada',
            'prioridad' => 'media',
            'user_id' => $dungeon->id
        ]);
        // Incidencia 13 - Salem
        Incidencia::create([
            'titulo' => 'Cámara web no funciona',
            'descripcion' => 'No se detecta la cámara en las reuniones de Zoom',
            'estado' => 'abierta',
            'prioridad' => 'baja',
            'user_id' => $salem->id
        ]);
        
        // Incidencia 14 - Malo Mentalo
        Incidencia::create([
            'titulo' => 'Mensajes no llegan',
            'descripcion' => 'El sistema de mensajería interna no entrega los mensajes',
            'estado' => 'en_proceso',
            'prioridad' => 'alta',
            'user_id' => $malmental->id
        ]);
        
        // Incidencia 15 - Dungeon Goblin
        Incidencia::create([
            'titulo' => 'Disco duro lleno',
            'descripcion' => 'El portátil indica que el espacio en disco está agotado',
            'estado' => 'cerrada',
            'prioridad' => 'alta',
            'user_id' => $dungeon->id
        ]);
    }
}