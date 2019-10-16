<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Antecedentesparentesco extends Model
{
    protected $fillable = [
        'Parentesco_id', 'Parentescotecedentes_id'
    ];

    public function pacienteantecedente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }

    public function parentesco()
    {
        return $this->belongsTo('App\Modelos\Parentesco');
    }
}
