<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public function sede()
    {
        return $this->belongsTo('App\Modelos\Sede');
    }
}
