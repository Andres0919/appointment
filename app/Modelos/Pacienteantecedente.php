<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Pacienteantecedente extends Model
{
    protected $fillable = [
        'Antecedente_id', 'Citapaciente_id', 'Descripcion', 'Usuario_id'
    ];

    public function antecedente()
    {
        return $this->belongsTo('App\Modelos\Antecedente');
    }

    public function paciente()
    {
        return $this->belongsTo('App\Modelos\Paciente');
    }
}
