<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tiporden extends Model
{
    protected $fillable = ['Nombre', 'Descripcion'];

    public function citapaciente()
    {
        return $this->hasMany('App\Modelos\citapaciente');
    }
}
