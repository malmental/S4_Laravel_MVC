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
        'user_id',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a muchos con tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relación con comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}