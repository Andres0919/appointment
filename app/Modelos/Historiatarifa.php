<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Historiatarifa extends Model
{
    protected $fillable = [
        'Tarifario_id', 'Tarifa', 'Valor'
    ];

    public function tarifario()
    {
        return $this->belongsTo('App\Modelos\Tarifario');
    }
}
