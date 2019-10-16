<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $fillable = [ 
        'Hipearterial', 'Diabetes', 'Isquemicacorazon', 'Trastornocoagulacion', 'Cancer', 
        'Insufrenalcronica', 'Asma', 'Epoc', 'Tiroides', 'Trastornotractodigestivo', 'Epilepsia', 
        'Trastornopsiquiatrico', 'Vih',
    ];

    public function atencionpatologia()
    {
        return $this->hasMany('App\Modelos\Atencionpatologia');
    }

}
