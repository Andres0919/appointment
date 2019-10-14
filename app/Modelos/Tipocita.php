<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipocita extends Model
{
    protected $fillable = [
        'Nombre', 'Descripcion', 'Estado_id'
    ];

    public function citas()
    {
        return $this->hasMany('App\Modelos\citapaciente');
    }
    
}

