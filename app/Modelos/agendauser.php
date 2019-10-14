<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class agendauser extends Model
{
    protected $fillable = [
        'Medico_id', 'Agenda_id',
    ];

    public function agenda(){
        
        return $this->belongsTo('App\Modelos\Agenda');
    }
}
