<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    protected $fillable = [
        'Nombre', 'Descripcion', 'Responsable', 'Tipofamilia_id', 'Estado_id'
    ];

    public function cups()
    {
        return $this->belongsToMany('App\Modelos\Cup', 'Cupfamilias');
    }

    public function tipofamilia()
    {
        return $this->belongsTo('App\Modelos\Tipofamilia');
    }
}
