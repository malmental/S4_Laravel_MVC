<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

