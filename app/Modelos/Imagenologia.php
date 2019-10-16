<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Imagenologia extends Model
{
    protected $fillable = [
        'Citapaciente_id', 'Indicacion', 'Hallazgos', 'Conclusion'
    ];

}
