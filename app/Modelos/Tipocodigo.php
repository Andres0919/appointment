<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipocodigo extends Model
{
    protected $fillable = [
        'Nombre', 'Descripcion', 'Estado_id'
    ];
}
