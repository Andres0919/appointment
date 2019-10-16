<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $fillable = [
        'Detallearticulo_id', 'Prestador_id', 'Valor', 'Iva', 'Valortotal', 'Estado_id'
    ];

    public function prestadore()
    {
        return $this->belongsTo('App\Modelos\Prestadore');
    }

    public function detallearticulo()
    {
        return $this->belongsTo('App\Modelos\Detallearticulo');
    }

}
