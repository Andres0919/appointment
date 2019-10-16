<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $fillable = ['Tiporden_id', 'Cita_id','Usuario_id','paginacion', 'Fechadispensacion', 'Estado_id', 'Fechaorden'];

    public function tiporden()
    {
        return $this->belongsTo('App\Modelos\Tiporden');
    }

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }

    public function cups()
    {
        return $this->hasMany('App\Modelos\Cup');
    }

    public function cupordens(){
        return $this->hasMany('App\Modelos\Cuporden','Orden_id');
    }

    public function detaarticulordens()
    {
        return $this->hasMany('App\Modelos\Detaarticulorden','Orden_id');
    }

    public function incapacidad()
    {
        return $this->belongsTo('App\Modelos\Incapacidade');
    }
}
