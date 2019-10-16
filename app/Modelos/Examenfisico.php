<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Examenfisico extends Model
{
    protected $fillable = [ 'Citapaciente_id', 'Peso', 'Talla', 'Imc', 'Clasificacion', 'Perimetroabdominal', 
                            'Perimetrocefalico', 'Frecucardiaca', 'Pulsos', 'Frecurespiratoria', 'Temperatura', 
                            'Saturacionoxigeno', 'Posicion', 'Lateralidad', 'Presionsistolica', 'Presiondiastolica', 
                            'Presionarterialmedia', 'Condiciongeneral', 'Cabezacuello', 'Ojosfondojos', 'Agudezavisual', 
                            'Cardiopulmonar', 'Abdomen', 'Osteomuscular', 'Extremidades', 'Pulsosperifericos', 'Neurologico', 
                            'Reflejososteotendinos', 'Pielfraneras', 'Genitourinario', 'Examenmama', 'Tactoretal', 'Examenmental',
    ];

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }
}
