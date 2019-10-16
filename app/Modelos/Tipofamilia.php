<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipofamilia extends Model
{
    protected $fillable = [
        'Nombre', 'Descripcion', 'Estado_id'
    ];

    public function familias()
    {
        return $this->hasMany('App\Modelos\Familia');
    }
}
