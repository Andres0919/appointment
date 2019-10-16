<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $fillable = [
        'Citapaciente_id' ,'Motivo', 'Usuariosuspende_id'
    ];

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }
}
