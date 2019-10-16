<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipomanuale extends Model
{
    protected $fillable =[
        'Nombre', 'Descripcion', 'Estado_id'
    ];

    public function codigomanual()
    {
        return $this->hasMany('App\Modelos\Codigomanual');
    }
}
