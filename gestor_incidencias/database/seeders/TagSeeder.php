<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Incidencia;
class TagSeeder extends Seeder
{
    public function run(): void
    {
        // Crear tags
        $tags = [
            'urgente' => Tag::firstOrCreate(['nombre' => 'urgente']),
            'hardware' => Tag::firstOrCreate(['nombre' => 'hardware']),
            'software' => Tag::firstOrCreate(['nombre' => 'software']),
            'red' => Tag::firstOrCreate(['nombre' => 'red']),
            'seguridad' => Tag::firstOrCreate(['nombre' => 'seguridad']),
            'email' => Tag::firstOrCreate(['nombre' => 'email']),
            'login' => Tag::firstOrCreate(['nombre' => 'login']),
            'pendiente' => Tag::firstOrCreate(['nombre' => 'pendiente']),
        ];

        // Obtener incidencias por título
        $incidenciaLogin = Incidencia::where('titulo', 'Error en el login')->first();
        $incidenciaPantalla = Incidencia::where('titulo', 'Pantalla azul')->first();
        $incidenciaTeclado = Incidencia::where('titulo', 'Teclado no funciona')->first();
        $incidenciaInternet = Incidencia::where('titulo', 'Internet lento')->first();
        $incidenciaImpresion = Incidencia::where('titulo', 'Error de impresión')->first();
        $incidenciaCorreo = Incidencia::where('titulo', 'Correo no sincroniza')->first();
        $incidenciaPC = Incidencia::where('titulo', 'No enciende el PC')->first();
        $incidenciaWiFi = Incidencia::where('titulo', 'WiFi no conecta')->first();
        $incidenciaApp = Incidencia::where('titulo', 'Aplicación no responde')->first();
        $incidenciaPassword = Incidencia::where('titulo', 'Contraseña expirada')->first();
        $incidenciaImpresora = Incidencia::where('titulo', 'Impresora atascada')->first();
        $incidenciaAntivirus = Incidencia::where('titulo', 'Antivirus desactualizado')->first();
        $incidenciaCamara = Incidencia::where('titulo', 'Cámara web no funciona')->first();
        $incidenciaMensajes = Incidencia::where('titulo', 'Mensajes no llegan')->first();
        $incidenciaDisco = Incidencia::where('titulo', 'Disco duro lleno')->first();
        
        // Asociar tags a incidencias
        if ($incidenciaLogin) $incidenciaLogin->tags()->sync([$tags['urgente']->id, $tags['login']->id]);
        if ($incidenciaPantalla) $incidenciaPantalla->tags()->sync([$tags['hardware']->id, $tags['urgente']->id]);
        if ($incidenciaTeclado) $incidenciaTeclado->tags()->sync([$tags['hardware']->id]);
        if ($incidenciaInternet) $incidenciaInternet->tags()->sync([$tags['red']->id]);
        if ($incidenciaImpresion) $incidenciaImpresion->tags()->sync([$tags['hardware']->id]);
        if ($incidenciaCorreo) $incidenciaCorreo->tags()->sync([$tags['email']->id]);
        if ($incidenciaPC) $incidenciaPC->tags()->sync([$tags['hardware']->id, $tags['urgente']->id]);
        if ($incidenciaWiFi) $incidenciaWiFi->tags()->sync([$tags['red']->id]);
        if ($incidenciaApp) $incidenciaApp->tags()->sync([$tags['software']->id]);
        if ($incidenciaPassword) $incidenciaPassword->tags()->sync([$tags['login']->id, $tags['urgente']->id]);
        if ($incidenciaImpresora) $incidenciaImpresora->tags()->sync([$tags['hardware']->id]);
        if ($incidenciaAntivirus) $incidenciaAntivirus->tags()->sync([$tags['seguridad']->id]);
        if ($incidenciaCamara) $incidenciaCamara->tags()->sync([$tags['hardware']->id]);
        if ($incidenciaMensajes) $incidenciaMensajes->tags()->sync([$tags['email']->id, $tags['urgente']->id]);
        if ($incidenciaDisco) $incidenciaDisco->tags()->sync([$tags['software']->id, $tags['urgente']->id]);
    }
}