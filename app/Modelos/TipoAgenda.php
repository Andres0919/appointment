<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TipoAgenda extends Model
{
    protected $fillable = ['name', 'Estado'];

    public function especialidades()
    {
        return $this->hasMany('App\Modelos\Especialidade');
    }
}
