<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Conducta extends Model
{
    protected $fillable = [
        'Citapaciente_id', 'Planmanejo', 'Recomendaciones', 'Destinopaciente', 'Finalidad'
    ];

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }
}
