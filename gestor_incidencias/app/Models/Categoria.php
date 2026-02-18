<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre'
    ];

    public function incidencias()
    {
        return $this->belongsToMany(Incidencia::class);
    }
}
