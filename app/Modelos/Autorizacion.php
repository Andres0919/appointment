<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    protected $fillable = [
        'Articulorden_id', 'Cuporden_id', 'Usuario_id', 'Nota'
    ];
}
