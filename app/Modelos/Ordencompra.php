<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Ordencompra extends Model
{
    protected $fillable = [
        'Bodegarticulo_id', 'Cantidad', 'Prestador_id', 'Usuario_id', 'Usuarioresponde_id', 'Estado_id'
    ];

    public function bodegarticulo()
    {
        return $this->belongsTo('App\Modelos\bodegarticulo');
    }
}
