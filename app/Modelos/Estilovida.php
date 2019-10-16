<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Estilovida extends Model
{
    protected $fillable = [ 'Citapaciente_id', 'Dietasaludable', 'Suenoreparador', 
                            'Duermemenoseishoras', 'Altonivelestres', 'Actividadfisica', 'Frecuenciasemana', 
                            'Duracion', 'Fumacantidad', 'Fumainicio', 'Fumadorpasivo', 'Cantidadlicor', 
                            'Licorfrecuencia', 'Consumopsicoactivo', 'Psicoactivocantidad', 'Estilovidaobservaciones',
                        ];

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }
}

