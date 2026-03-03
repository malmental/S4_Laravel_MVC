<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidenciaValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function titulo_es_required()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'descripcion' => 'Test descripcion',
                'estado' => 'abierta',
                'prioridad' => 'alta',
        ]);

        $response->assertSessionHasErrors('titulo');
    }

    /** @test */
    public function titulo_no_puede_exceder_255_caracteres()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => str_repeat('a', 256),
                'descripcion' => 'Test descripcion',
                'estado' => 'abierta',
                'prioridad' => 'alta',
            ]);

        $response->assertSessionHasErrors('titulo');
    }

    /** @test */
    public function descripcion_es_required()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => 'Test titulo',
                'estado' => 'abierta',
                'prioridad' => 'alta',
            ]);

        $response->assertSessionHasErrors('descripcion');
    }

    /** @test */
    public function estado_debe_ser_valido()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => 'Test titulo',
                'descripcion' => 'Test descripcion',
                'estado' => 'estado_invalido',
                'prioridad' => 'alta',
            ]);

        $response->assertSessionHasErrors('estado');
    }

    /** @test */
    public function prioridad_debe_ser_valida()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => 'Test titulo',
                'descripcion' => 'Test descripcion',
                'estado' => 'abierta',
                'prioridad' => 'prioridad_invalida',
            ]);

        $response->assertSessionHasErrors('prioridad');
    }

    /** @test */
    public function tags_es_opcional()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => 'Test titulo',
                'descripcion' => 'Test descripcion',
                'estado' => 'abierta',
                'prioridad' => 'alta',
            ]);

        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function valores_validos_pasan_validacion()
    {
        $response = $this->actingAs($this->user)
            ->post('/incidencias', [
                'titulo' => 'Test titulo',
                'descripcion' => 'Test descripcion',
                'estado' => 'abierta',
                'prioridad' => 'alta',
            ]);

        $response->assertSessionHasNoErrors();
    }
}