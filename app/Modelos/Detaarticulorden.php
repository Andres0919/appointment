<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Detaarticulorden extends Model
{
    protected $fillable = ['Orden_id', 'codesumi_id','Estado_id', 'Cantidadosis', 'Via', 'Unidadmedida', 'Frecuencia', 'Unidadtiempo', 'Duracion', 'Cantidadmensual', 'Cantidadmensualdisponible', 'NumMeses', 'Cantidadpormedico', 'Observacion', 'Fechaorden'];

    public function detallearticulo()
    {
        return $this->belongsTo('App\Modelos\Detallearticulo','Orden_id');
    }

    public function orden()
    {
        return $this->belongsTo('App\Modelos\Orden');
    }
    
    public function codesumis()
    {
        return $this->belongsTo('App\Modelos\Codesumi','Codesumi_id');
    }
}
