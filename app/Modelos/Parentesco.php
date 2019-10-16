<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $fillable = [
        'Nombre'
    ];

    public function parentescoantecedentes()
    {
        return $this->hasMany('App\Modelos\Parentescoantecedente');
    }
}
