<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $fillable = [
        'Descripcion', 'Tabla', 'Usuariomodifica_id','Model_id','Motivo'
    ];
}
