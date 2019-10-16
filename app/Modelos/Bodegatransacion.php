<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Bodegatransacion extends Model
{
    protected $fillable = [
        'Lote_id', 'Movimiento_id', 'Cantidadtotal', 'CantidadtotalFactura', 'Cantidadtotalinventario', 'Precio',
        'Valor', 'Valortotal', 'Valorpromedio', 'Estado_id', 'Bodegarticulo_id'
    ];

    public function bodegarticulo()
    {
        return $this->belongsTo('App\Modelos\Bodegarticulo');
    }

    public function movimeintos()
    {
        return $this->belongsTo('App\Modelos\Movimiento');
    }

    public function lote()
    {
        return $this->belongsTo('App\Modelos\Lote');
    }

}
