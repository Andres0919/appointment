<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    protected $fillable = [
        'Codigo', 'Nombre', 'Genero', 'Edad_Inicial', 'Edad_Final', 'Archivo', 'Qx', 'Dx_Requerido', 'Nivelordenamiento', 'Requiere_auditoria',
        'Periodicidad', 'Ufuncional', 'Servicio_id'
    ];

    public function cupservicios()
    {
        return $this->hasMany('App\Modelos\Cupservicio');
    }

    public function cup()
    {
        return $this->belongsTo('App\Modelos\Cup');
    }

    public function codigomanual()
    {
        return $this->hasMany('App\Modelos\Codigomanual');
    }

    public function ordens()
    {
        return $this->hasMany('App\Modelos\Orden');
    }
}
