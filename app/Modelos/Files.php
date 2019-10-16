<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $fillable = [
        'Name', 'Path', 'CitaPaciente_id'
    ];

    public function citapaciente()
    {
        return $this->belongsTo('App\Modelos\citapaciente');
    }
}
