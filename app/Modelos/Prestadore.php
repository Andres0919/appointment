<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Prestadore extends Model
{
    protected $fillable = [
        'Tipoprestador_id', 'Nombre','Nit','Direccion','Correo1','Correo2','Telefono1','Telefono2', 'Codigo_prestador','Estado_id',
    ];

    public function codepropio()
    {
        return $this->hasMany('App\Modelos\Codepropio', 'Prestador_id');
    }

    public function sedeproveedores()
    {
        return $this->hasMany('App\Modelos\Sedeprovedore', 'Prestador_id');
    }
}
