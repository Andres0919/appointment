<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cuporden extends Model
{
    protected $fillable = ['Orden_id', 'Cup_id','Cantidad','Ubicacion_id','Observacionorden' ,'valor_tarifa', 'valor_total', 'valor_transporte', 'Estado_id'];

    public function cup()
    {
        return $this->belongsTo('App\Modelos\Cup');
    }

    public function orden()
    {
        return $this->belongsTo('App\Modelos\Orden');
    }
}
