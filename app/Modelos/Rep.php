<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Rep extends Model
{
    protected $guarded = [];

    public function movimientos()
    {
        return $this->hasMany('App\Modelos\Movimiento');
    }
}
