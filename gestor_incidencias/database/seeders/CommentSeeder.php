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
        // Obtener usuarios
        $salem = User::where('email', 'salem@telsur.cl')->first();
        $malmental = User::where('email', 'malmental@telsur.cl')->first();
        $dungeon = User::where('email', 'dungeongoblin@telsur.cl')->first();
        
        // Obtener incidencias por título
        $incidentes = [
            'Error en el login' => Incidencia::where('titulo', 'Error en el login')->first(),
            'Pantalla azul' => Incidencia::where('titulo', 'Pantalla azul')->first(),
            'Teclado no funciona' => Incidencia::where('titulo', 'Teclado no funciona')->first(),
            'Internet lento' => Incidencia::where('titulo', 'Internet lento')->first(),
            'Error de impresión' => Incidencia::where('titulo', 'Error de impresión')->first(),
            'Correo no sincroniza' => Incidencia::where('titulo', 'Correo no sincroniza')->first(),
            'No enciende el PC' => Incidencia::where('titulo', 'No enciende el PC')->first(),
            'WiFi no conecta' => Incidencia::where('titulo', 'WiFi no conecta')->first(),
            'Aplicación no responde' => Incidencia::where('titulo', 'Aplicación no responde')->first(),
            'Contraseña expirada' => Incidencia::where('titulo', 'Contraseña expirada')->first(),
            'Impresora atascada' => Incidencia::where('titulo', 'Impresora atascada')->first(),
            'Antivirus desactualizado' => Incidencia::where('titulo', 'Antivirus desactualizado')->first(),
            'Cámara web no funciona' => Incidencia::where('titulo', 'Cámara web no funciona')->first(),
            'Mensajes no llegan' => Incidencia::where('titulo', 'Mensajes no llegan')->first(),
            'Disco duro lleno' => Incidencia::where('titulo', 'Disco duro lleno')->first(),
        ];
        
        // === INCIDENCIA 1: Error en el login ===
        $c1 = Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['Error en el login']->id,
            'contenido' => 'Estoy investigando el problema con el equipo de IT.'
        ]);
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Error en el login']->id,
            'parent_id' => $c1->id,
            'contenido' => 'Parece que es cosa de Google.'
        ]);
        
        // === INCIDENCIA 2: Pantalla azul ===
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => $incidentes['Pantalla azul']->id,
            'contenido' => 'Necesito más información sobre cuándo ocurre el error.'
        ]);
        
        // === INCIDENCIA 3: Teclado no funciona ===
        $c2 = Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['Teclado no funciona']->id,
            'contenido' => 'Ya pedí teclado nuevo, llega mañana.'
        ]);
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Teclado no funciona']->id,
            'parent_id' => $c2->id,
            'contenido' => 'Gracias por la gestión!'
        ]);
        
        // === INCIDENCIA 4: Internet lento ===
        $c3 = Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['Internet lento']->id,
            'contenido' => '¿Es problema del router o del cableado?'
        ]);
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Internet lento']->id,
            'parent_id' => $c3->id,
            'contenido' => 'Creo que es el router, voy a reiniciarlo.'
        ]);
        
        // === INCIDENCIA 7: No enciende el PC ===
        $c4 = Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['No enciende el PC']->id,
            'contenido' => 'El cable de alimentación está bien conectado?'
        ]);
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => $incidentes['No enciende el PC']->id,
            'parent_id' => $c4->id,
            'contenido' => 'Ya checkeaste todos los cables?.'
        ]);
        
        // === INCIDENCIA 8: WiFi no conecta ===
        $c5 = Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['WiFi no conecta']->id,
            'contenido' => 'Ya probé reiniciar el portátil y el router.'
        ]);
        Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['WiFi no conecta']->id,
            'parent_id' => $c5->id,
            'contenido' => 'Voy a verificar la configuración de red.'
        ]);
        
        // === INCIDENCIA 9: Aplicación no responde ===
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => $incidentes['Aplicación no responde']->id,
            'contenido' => 'Problema resuelto después de reinstalar la aplicación.'
        ]);
        
        // === INCIDENCIA 10: Contraseña expirada ===
        $c6 = Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['Contraseña expirada']->id,
            'contenido' => 'Necesito que me reseteen la contraseña urgentemente.'
        ]);
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => $incidentes['Contraseña expirada']->id,
            'parent_id' => $c6->id,
            'contenido' => 'Enviando link de recuperación ahora.'
        ]);
        
        // === INCIDENCIA 11: Impresora atascada ===
        $c7 = Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Impresora atascada']->id,
            'contenido' => 'Ya quité el papel atascado pero sigue sin funcionar.'
        ]);
        Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['Impresora atascada']->id,
            'parent_id' => $c7->id,
            'contenido' => 'Vamos a solicitar mantenimiento técnico.'
        ]);
        
        // === INCIDENCIA 13: Cámara web no funciona ===
        Comment::create([
            'user_id' => $salem->id,
            'incidencia_id' => $incidentes['Cámara web no funciona']->id,
            'contenido' => '¿Drivers actualizados? Voy a verificar.'
        ]);
        
        // === INCIDENCIA 14: Mensajes no llegan ===
        $c8 = Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Mensajes no llegan']->id,
            'contenido' => 'Es urgente, necesito comunicarme con el equipo.'
        ]);
        Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => $incidentes['Mensajes no llegan']->id,
            'parent_id' => $c8->id,
            'contenido' => 'Revisando el servidor de mensajería ahora.'
        ]);
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Mensajes no llegan']->id,
            'parent_id' => $c8->id,
            'contenido' => 'Gracias por la rapidez!'
        ]);
        
        // === INCIDENCIA 15: Disco duro lleno ===
        $c9 = Comment::create([
            'user_id' => $dungeon->id,
            'incidencia_id' => $incidentes['Disco duro lleno']->id,
            'contenido' => 'Necesito liberar espacio urgentemente.'
        ]);
        Comment::create([
            'user_id' => $malmental->id,
            'incidencia_id' => $incidentes['Disco duro lleno']->id,
            'parent_id' => $c9->id,
            'contenido' => 'Puedes ejecutar el limpiador de disco oformatear.'
        ]);
    }
}