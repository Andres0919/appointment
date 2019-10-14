<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [ 'Agenda_id', 'Hora_Inicio','Hora_Final', 'Cantidad','Estado_id'];

    public function agenda()
    {
        return $this->belongsTo('App\Modelos\Cita');
    }

    public function estados()
    {
        return $this->belongsToMany('App\Modelos\Estado')->withPivot('User_id', 'Estado_id', 'Cita_id', 'Actualizado_por')->withTimestamps();
    }

    public function paciente()
    {
        return $this->belongsToMany('App\Modelos\Paciente')->withPivot('Paciente_id', 'Cita_id', 'Usuario_id', 'Cup_id', 'Fecha_solicita', 'Estado_id')->withTimestamps();
    }
}
