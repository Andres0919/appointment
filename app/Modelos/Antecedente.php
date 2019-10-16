<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    protected $fillable = [
        'Nombre', 'Esfamiliar'
    ];

    public function paciente()
    {
        return $this->hasMany('App\Modelos\Paciente');
    }

    public function parentesco()
    {
        return $this->hasMany('App\Modelos\Parentesco');
    }
}
