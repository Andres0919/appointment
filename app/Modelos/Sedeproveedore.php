<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Sedeproveedore extends Model
{
    protected $fillable = [
        'Municipio_id', 'Prestador_id', 'Codigo_habilitacion', 'Nombre', 'Nivelatencion', 'Correo1', 'Correo2', 'Telefono1', 'Telefono2', 'Direccion', 'Estado_id'
    ];

    public function prestador()
    {
        return $this->belongsTo('App\Modelos\Prestadore');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Modelos\Municipio');
    }

    public function contratos()
    {
        return $this->hasMany('App\Modelos\Contratos');
    }

    public function codepropios()
    {
        return $this->hasMany('App\Modelos\Codepropio');
    }
}
