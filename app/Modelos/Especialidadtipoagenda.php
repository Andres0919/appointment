<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Especialidadtipoagenda extends Model
{
    protected $fillable = [
        'Especialidad_id', 'Tipoagenda_id', 'Duracion'
    ];

    protected $table = "especialidade_tipoagenda";

    public function agendas()
    {
        return $this->hasMany('App\Modelos\Agenda');
    }
    
}
