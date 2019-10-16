<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Codesumi extends Model
{
    protected $fillable = ['Nombre', 'Codigo', 'Tipocodesumi_id','Frecuencia', 'Cantidadmaxordenar','Nivel_Ordenamiento','Requiere_autorizacion', 'Estado_id'];

    public function codepropio()
    {
        return $this->hasMany('App\Modelos\Codepropio');
    }

    public function detallearticulos(){
        return $this->hasMany('App\Modelos\Detallearticulo','Codesumi_id');
    }
}
