<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cie10paciente extends Model
{
    protected $guarded = [];

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }

    public function cie10()
    {
        return $this->belongsTo('App\Modelos\Cie10');
    }
}
