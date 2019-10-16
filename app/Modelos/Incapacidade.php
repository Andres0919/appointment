<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Incapacidade extends Model
{
    protected $fillable = [ 'Fechainicio', 'Dias', 'Fechafinal', 'Prorroga', 'Adjuntoincapacidad',
                        'Orden_id', 'Cie10_id', 'Usuarioordena_id', 'Usuarioedit_id', 'Estado_id', 'Descripcion',
                        'Contingencia', 'Laboraen'
    ];
    
    public function orden()
    {
        return $this->belongsTo('App\Modelos\Orden');
    }
}
