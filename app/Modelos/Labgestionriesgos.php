<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Labgestionriesgos extends Model
{
    protected $fillable = [
        'Citapaciente_id','Glicemia','Glicemiafecha','Hemoglobinaglicosilada',
        'Hemoglobinafecha','Colesteroltotal','Colesteroltotalfecha','Colesterolhdl',
        'Colesterolhdlfecha','Colesterolldl','Colesterolldlfecha','Trigliceridos',
        'Trigliceridosfecha','Proteinuria','Proteinuriafecha','Uroanalisis',
        'Uroanalisisfecha','Microalbuminuria','Microalbuminuriafecha','Creatinina',
        'Creatininafecha','Disminuciondetfg','Resultadoframinghan','Cumplemetaterapeutica',
        'Pacienteadherente','Pacientecontrolado','Insulinorequiriente','Signosdealarma',
        'Hospitalizacionesrecientes','Valoracionpornutricion','Valoracionporpsicologia',
        'Asisteatallergrupaleducativo','Periodicidadproximocontrol','Proximocontrolcon',
    ];
}
