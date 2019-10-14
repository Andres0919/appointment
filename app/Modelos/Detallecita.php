<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Detallecita extends Model
{
    protected $fillable = [
        'Usuario_id','Citapaciente_id','Motivo', 'Estado_id'
    ];

    public function Cup()
    {
        return $this->belongsTo('App\Modelos\Cup');
    }
}
