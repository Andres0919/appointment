<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Valormanual extends Model
{
    protected $fillable =[
        'Valor', 'Anio', 'Codigomanual_id'
    ];

    public function codigomanual()
    {
        return $this->belongsTo('App\Modelos\Codigomanual');
    }
    
}
