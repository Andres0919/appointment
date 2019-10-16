<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    protected $fillable = [
        'Municipio_id', 'Tipobodega_id', 'Nombre', 'Direccion', 'Telefono', 'Horainicio', 'Horafin', 'Estado'
    ];

    public function tipobodega()
    {
        return $this->belongsTo('App\Modelos\Tipobodega');
    }
}
