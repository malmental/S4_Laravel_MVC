<?php

namespace Tests\Unit;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidenciaModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function incidencia_pertenece_a_usuario()
    {
        $user = User::factory()->create();
        $incidencia = Incidencia::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $incidencia->user);
        $this->assertEquals($user->id, $incidencia->user->id);
    }

    /** @test */
    public function incidencia_tiene_muchas_tags()
    {
        $incidencia = Incidencia::factory()->create();
        $tag = \App\Models\Tag::factory()->create();
        $incidencia->tags()->attach($tag->id);
        $this->assertTrue($incidencia->tags->contains($tag));
    }

    /** @test */
    public function incidencia_tiene_muchos_comentarios()
    {
        $incidencia = Incidencia::factory()->create();
        $comment = \App\Models\Comment::factory()->create(['incidencia_id' => $incidencia->id]);
        $this->assertTrue($incidencia->comments->contains($comment));
    }

    /** @test */
    public function scope_abierta_filtra_correctamente()
    {
        $incidenciaAbierta = Incidencia::factory()->create(['estado' => 'abierta']);
        Incidencia::factory()->create(['estado' => 'cerrada']);
        $result = Incidencia::abierta()->get();
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->contains($incidenciaAbierta));
    }

    /** @test */
    public function scope_alta_filtra_correctamente()
    {
        $incidenciaAlta = Incidencia::factory()->create(['prioridad' => 'alta']);
        Incidencia::factory()->create(['prioridad' => 'baja']);
        $result = Incidencia::alta()->get();
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->contains($incidenciaAlta));
    }

    /** @test */
    public function fillable_permite_campos_correctos()
    {
        $incidencia = new Incidencia();
        $fillable = $incidencia->getFillable();
        $this->assertContains('titulo', $fillable);
        $this->assertContains('descripcion', $fillable);
        $this->assertContains('estado', $fillable);
        $this->assertContains('prioridad', $fillable);
        $this->assertContains('user_id', $fillable);
    }
}