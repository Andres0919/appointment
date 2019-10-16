<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cupservicio extends Model
{
    protected $fillable = [
        'Cup_id', 'Tiposervicio_id'
    ];

    public function tiposervicio()
    {
        return $this->belongsTo('App\Modelos\Tiposervicio');
    }

    public function cup()
    {
        return $this->belongsTo('App\Modelos\Cup');
    }

    public function tarifas()
    {
        return $this->hasMany('App\Modelos\Tarifa');
    }
}
