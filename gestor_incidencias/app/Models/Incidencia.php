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

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('replies');
    }

    // SCOPES
    public function scopeAbierta($query)
    {
        return $query->where('estado', 'abierta');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeCerrada($query)
    {
        return $query->where('estado', 'cerrada');
    }

    public function scopeAlta($query)
    {
        return $query->where('prioridad', 'alta');
    }

    public function scopeMedia($query)
    {
        return $query->where('prioridad', 'media');
    }

    public function scopeBaja($query)
    {
        return $query->where('prioridad', 'baja');
    }

    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeConTags($query)
    {
        return $query->with('tags');
    }

    public function scopeConComentarios($query)
    {
        return $query->with('comments.user', 'comments.replies', 'comments.replies.user');
    }
}