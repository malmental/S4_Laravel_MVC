<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenido',
        'user_id',
        'incidencia_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }
}
