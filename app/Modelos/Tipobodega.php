<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipobodega extends Model
{
    protected $fillable = [
        'Nombre', 'Estado'
    ];

    public function bodega()
    {
        return $this->hasMany('App\Modelos\Bodega');
    }
}
