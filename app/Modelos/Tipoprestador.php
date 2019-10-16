<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipoprestador extends Model
{
    protected $Fillable = [
        'Nombre', 'Estado_id'
    ];

    public function prestadores()
    {
        return $this->hasMany('App\Modelos\Prestadore');
    }
}
