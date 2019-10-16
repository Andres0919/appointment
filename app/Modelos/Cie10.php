<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cie10 extends Model
{
    protected $fillable = [ 'Capitulo', 'Nombre_Capitulo', 'Codigo_CIE10', 'Descripcion', 'Limitada_Sexo', 
                            'Inferior_edad', 'Superior_edad', 'Visible', 'Nombre'];
    
    public function citapacientes()
    {
        return $this->hasMany('App\Modelos\citapaciente');
    }
}
