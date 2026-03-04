<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Incidencia $incidencia;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->incidencia = Incidencia::factory()->create();
    }

    public function test_usuario_puede_crear_comentario()
    {
        $response = $this->actingAs($this->user)
            ->post('/comments', [
                'contenido' => 'Nuevo comentario',
                'incidencia_id' => $this->incidencia->id,
            ]);

        $this->assertDatabaseHas('comments', [
            'contenido' => 'Nuevo comentario',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_contenido_es_required()
    {
        $response = $this->actingAs($this->user)
            ->post('/comments', [
                'incidencia_id' => $this->incidencia->id,
            ]);

        $response->assertSessionHasErrors('contenido');
    }

    public function test_usuario_puede_responder_comentario()
    {
        $comentarioPadre = Comment::factory()->create([
            'incidencia_id' => $this->incidencia->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post('/comments', [
                'contenido' => 'Respuesta al comentario',
                'incidencia_id' => $this->incidencia->id,
                'parent_id' => $comentarioPadre->id,
            ]);

        $this->assertDatabaseHas('comments', [
            'contenido' => 'Respuesta al comentario',
            'parent_id' => $comentarioPadre->id,
        ]);
    }

    public function test_usuario_puede_eliminar_su_comentario()
    {
        $comentario = Comment::factory()->create([
            'user_id' => $this->user->id,
            'incidencia_id' => $this->incidencia->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/comments/{$comentario->id}");

        $this->assertDatabaseMissing('comments', [
            'id' => $comentario->id,
        ]);
    }
}
