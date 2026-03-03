<?php

namespace Tests\Feature;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidenciaCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $otroUsuario;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->otroUsuario = User::factory()->create();
    }

    public function test_usuario_puede_crear_incidencia()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => 'Nueva incidencia',
                'descripcion' => 'Descripcion de prueba',
                'estado' => 'abierta',
                'prioridad' => 'alta',
            ]);

        $this->assertDatabaseHas('incidencias', [
            'titulo' => 'Nueva incidencia',
            'user_id' => $this->user->id,
        ]);

        $response->assertRedirect('/incidencias');
    }

    public function test_usuario_puede_ver_sus_incidencias()
    {
        Incidencia::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get('/incidencias');

        $response->assertStatus(200);
    }

    public function test_usuario_puede_editar_su_incidencia()
    {
        $incidencia = Incidencia::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->put("/incidencias/{$incidencia->id}", [
                'titulo' => 'Titulo actualizado',
                'descripcion' => 'Descripcion actualizada',
                'estado' => 'cerrada',
                'prioridad' => 'baja',
            ]);

        $this->assertDatabaseHas('incidencias', [
            'id' => $incidencia->id,
            'titulo' => 'Titulo actualizado',
        ]);
    }

    public function test_usuario_puede_eliminar_su_incidencia()
    {
        $incidencia = Incidencia::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete("/incidencias/{$incidencia->id}");

        $this->assertDatabaseMissing('incidencias', [
            'id' => $incidencia->id,
        ]);
    }

    public function test_usuario_no_puede_editar_incidencia_ajena()
    {
        $incidencia = Incidencia::factory()->create(['user_id' => $this->otroUsuario->id]);
        
        $response = $this->actingAs($this->user)
            ->get("/incidencias/{$incidencia->id}/edit");

        $response->assertStatus(403);
    }

    public function test_usuario_no_puede_eliminar_incidencia_ajena()
    {
        $incidencia = Incidencia::factory()->create(['user_id' => $this->otroUsuario->id]);

        $response = $this->actingAs($this->user)
            ->delete("/incidencias/{$incidencia->id}");

        $response->assertStatus(403);
    }

    public function test_usuario_no_logueado_no_puede_acceder()
    {
        $response = $this->get('/incidencias');

        $response->assertRedirect('/login');
    }
}