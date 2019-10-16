<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Citapatologias extends Model
{
    protected $fillable = [
        'Cie10_id', 'Cita_id', 'Estado_id'
    ];

    public function cie10()
    {
        return $this->belongsTo('App\Modelos\Cie10');
    }

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }
}
