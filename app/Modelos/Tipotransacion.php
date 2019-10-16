<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipotransacion extends Model
{
    protected $fillable = [
        'Transacion_id', 'Tipo_id'
    ];

    public function tipo()
    {
        return $this->belongsTo('App\Modelos\Tipo');
    }
}
