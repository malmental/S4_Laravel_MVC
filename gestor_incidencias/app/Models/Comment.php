<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'incidencia_id',
        'parent_id',
        'contenido'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
