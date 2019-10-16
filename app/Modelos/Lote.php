<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = ([
        'Numlote', 'Fvence', 'Cantidadisponible', 'Bodegarticulo_id', 'Estado_id'
    ]);

    public function bodegarticulo()
    {
        return $this->belongsTo('App\Modelos\Bodegarticulo');
    }

    public function bodedatransacions()
    {
        return $this->hasMany('App\Modelos\Bodegatransacion');
    }
}
