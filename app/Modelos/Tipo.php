<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = [
        'Nombre', 'Estado_id'
    ];

    public function tipotransacion()
    {
        return $this->hasMany('App\Modelos\Tipotransacion');
    }
}
