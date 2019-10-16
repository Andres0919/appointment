<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class actividadcargo extends Model
{
    protected $fillable = [
        'Cargo_id', 'Nombre', 'Estado_id'
    ];

    public function cargo()
    {
        return $this->belongsTo('App\Modelos\Cargo');
    }

    public function actividaduser()
    {
        return $this->hasMany('App\Modelos\Actividaduser');
    }
}
