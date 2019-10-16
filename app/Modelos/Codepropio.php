<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Codepropio extends Model
{
    protected $fillable = ['Codigo', 'Descripcion', 'Valor', 'Codesumi_id', 'sedeproveedor_id', 'Servicio_id', 'Estado_id'];

    public function codesumi()
    {
        return $this->belongsTo('App\Modelos\Codesumi');
    }

    public function sedeproveedores()
    {
        return $this->belongsTo('App\Modelos\Sedeproveedore');
    }
}
