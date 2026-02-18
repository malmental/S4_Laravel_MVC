<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación muchos a muchos con incidencias
    public function incidencias()
    {
        return $this->belongsToMany(Incidencia::class);
    }
}