<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Notastransacion extends Model
{
    protected $fillable = ['usuario_id', 'Movimiento_id', 'Nombre', 'Descripcion'];
}

