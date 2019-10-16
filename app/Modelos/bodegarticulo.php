<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class bodegarticulo extends Model
{
    protected $fillable = [
        'Bodega_id','Detallearticulo_id','Stock','Cantidadmaxima','Cantidadminima'
    ];

    public function bodega()
    {
        return $this->belongsTo('App\Modelos\Bodega');
    }

    public function Detallearticulo()
    {
        return $this->belongsTo('App\Modelos\Detallearticulo');
    }

    public function lotes()
    {
        return $this->hasMany('App\Modelos\Lote');
    }

    public function ordencompras()
    {
        return $this->hasMany('App\Modelos\Ordencompra');
    }
}
