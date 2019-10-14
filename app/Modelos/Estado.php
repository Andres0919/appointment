<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = ['Nombre', 'Tipo', 'Descripcion'];

    public function agendas()
    {
        return $this->belongsToMany('App\Modelos\Agenda');
    }

    public function pacientes()
    {
        return $this->belongsToMany('App\Modelos\Paciente');
    }

    public function citas()
    {
        return $this->belongsToMany('App\Modelos\Cita');
    }

    public function users()
    {
        return $this->belongsToMany('App\Modelos\User');
    }
}
