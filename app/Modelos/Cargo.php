<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'Nombre', 'Descripcion', 'Estado_id'
    ];

    public function actividadcargo()
    {
        return $this->hasMany('App\Modelos\Actividadcargo');
    }
}
