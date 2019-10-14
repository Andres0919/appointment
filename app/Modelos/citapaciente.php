<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class citapaciente extends Model
{
    protected $fillable = [
        'Paciente_id', 'Cita_id', 'Usuario_id', 'Tipocita_id', 'Fecha_solicita', 
        'Motivoconsulta', 'Enfermedadactual', 'Resultayudadiagnostica', 'Estado_id', 'Oftalmologico', 'Genitourinario',
         'Otorrinoralingologico', 'Linfatico', 'Osteomioarticular', 'Neurologico', 'Cardiovascular', 'Tegumentario', 
         'Respiratorio', 'Endocrinologico', 'Gastrointestinal', 'Norefiere'
    ];
    protected $table = 'cita_paciente';

    public function ordens()
    {
        return $this->hasMany('App\Modelos\Orden');
    }

    public function conduta()
    {
        return $this->belongsTo('App\Modelos\Conducta');
    }

    public function tipordens()
    {
        return $this->hasMany('App\Modelos\Tiporden');
    }

    public function cie10s()
    {
        return $this->hasMany('App\Modelos\Cie10');
    }

    public function ginecologicos()
    {
        return $this->hasMany('App\Modelos\Ginecologico');
    }

    public function examenfisico()
    {
        return $this->belongsTo('App\Modelos\Examenfisico');
    }

    public function estilovida()
    {
        return $this->belongsTo('App\Modelos\Estilovida');
    }

}
