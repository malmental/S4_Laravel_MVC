<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'user_id', // muy importante para la relación
    ];

    // Relación inversa: cada incidencia pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Relación muchos a muchos con Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relación uno a muchos con Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}