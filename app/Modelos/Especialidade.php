<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $fillable = [
        'Nombre', 'estado'
    ];

    public function cups()
    {
        return $this->hasMany('App\Modelos\Cup');
    }

    public function tipoagendas()
    {
        return $this->hasMany('App\Modelos\TipoAgenda');
    }
}
