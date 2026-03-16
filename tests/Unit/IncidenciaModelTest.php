<?php

namespace Tests\Unit;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IncidenciaModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_incidencia_pertenece_a_usuario()
    {
        $user = User::factory()->create();
        $incidencia = Incidencia::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $incidencia->user);
        $this->assertEquals($user->id, $incidencia->user->id);
    }

    public function test_incidencia_tiene_muchas_tags()
    {
        $incidencia = Incidencia::factory()->create();
        $tag = \App\Models\Tag::factory()->create();
        $incidencia->tags()->attach($tag->id);
        $this->assertTrue($incidencia->tags->contains($tag));
    }

    public function test_incidencia_tiene_muchos_comentarios()
    {
        $incidencia = Incidencia::factory()->create();
        $comment = \App\Models\Comment::factory()->create(['incidencia_id' => $incidencia->id]);
        $this->assertTrue($incidencia->comments->contains($comment));
    }

    public function test_fillable_permite_campos_correctos()
    {
        $incidencia = new Incidencia;
        $fillable = $incidencia->getFillable();
        $this->assertContains('titulo', $fillable);
        $this->assertContains('descripcion', $fillable);
        $this->assertContains('estado', $fillable);
        $this->assertContains('prioridad', $fillable);
        $this->assertContains('user_id', $fillable);
    }
}
