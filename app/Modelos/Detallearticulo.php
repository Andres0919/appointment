<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Detallearticulo extends Model
{
    protected $fillable = [ 'Subgrupo_id', 'Codesumi_id', 'Expediente', 'Producto', 'Titular', 'Registro_Sanitario', 'Invima', 
    'Fecha_Expedicion', 'Fecha_Vencimiento', 'Estado_Registro', 'Expediente_Cum', 'Consecutivo', 'Cantidad_Cum', 
    'Descripcion_Comercial', 'Estado_Cum', 'Fecha_Activo', 'Fecha_Inactivo', 'Muestra_Medica', 'Unidad', 'Atc', 'Descripcion_Atc', 
    'Via_Administracion', 'Concentracion', 'Principio_Activo', 'Unidad_Medida', 'Unidad_Referencia', 'Forma_Farmaceutica', 
    'Cum_Validacion', 'CUM_completo', 'Activo_HORUS', 'Regulado', 'Precio_maximo', 'Unidad_aux', 'POS', 'Alto_Costo', 'Acuerdo_228', 
    'Nivel_Ordenamiento', 'Requiere_autorizacion', 'Cantidad', 'Frecuencia', 'Estado_id',
    ];

    public function articulo()
    {
        return $this->belongsTo('App\Modelos\Articulo');
    }

    public function bodegarticulo()
    {
        return $this->hasMany('App\Modelos\Bodegarticulo');
    }

    public function codesumi()
    {
        return $this->belongsTo('App\Modelos\Codesumi');
    }

    public function catalogo()
    {
        return $this->hasMany('App\Modelos\Catalogo');
    }

    public function orden()
    {
        return $this->hasMany('App\Modelos\Orden');
    }
}
