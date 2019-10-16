<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['Citapaciente_id', 'Nivel', 'Marca'];

    public function paciente()
    {
        return $this->belongsTo('App\Modelos\Paciente');
    }
}
