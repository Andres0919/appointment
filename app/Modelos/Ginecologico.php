<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Ginecologico extends Model
{
    protected $fillable = ['Citapaciente_id', 'Fechaultimamenstruacion', 'Gestaciones', 'Partos', 'Abortoprovocado', 
                            'Abortoespontaneo', 'Mortinato', 'Gestantefechaparto', 'Gestantenumeroctrlprenatal', 'Eutoxico', 
                            'Cesaria', 'Cancercuellouterino', 'Ultimacitologia', 'Resultado', 'Menarquia', 'Ciclos', 'Regulares', 
                            'Observaciongineco'
                        ];

    public function citapaciente()
    {
        return $this->hasMany('App\Modelos\citapaciente');
    }
}
