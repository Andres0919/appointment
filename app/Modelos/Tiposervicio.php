<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tiposervicio extends Model
{
    protected $fillable = ['Nombre','Estado_id'];

    
    public function cupservicios()
    {
        return $this->hasMany('App\Modelos\Cupservicio');
    }
}
