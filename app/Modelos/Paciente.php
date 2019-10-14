<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'Region', 'Ut', 'Primer_Nom', 'SegundoNom', 'Primer_Ape', 'Segundo_Ape', 
        'Tipo_Doc', 'Num_Doc', 'Sexo', 'Fecha_Afiliado', 'Fecha_Naci', 'Edad_Cumplida', 
        'Discapacidad', 'Grado_Discapacidad', 'Tipo_Afiliado', 'Orden_Judicial', 'Num_Folio',
        'Fecha_Emision', 'Parentesco', 'TipoDoc_Cotizante', 'Doc_Cotizante', 'Tipo_Cotizante',
        'Estado_Afiliado', 'Dane_Mpio', 'Mpio_Afiliado', 'Dane_Dpto', 'Departamento', 'Subregion', 
        'Dpto_Atencion', 'Mpio_Atencion', 'IPS', 'Sede_Odontologica', 'Medicofamilia', 'Etnia',
        'Nivel_Sisben', 'Laboraen', 'Mpio_Labora', 'Direccion_Residencia', 'Mpio_Residencia', 
        'Telefono', 'Correo', 'Estrato', 'Celular', 'Sexo_Biologico', 'Tipo_Regimen', 'Num_Hijos', 
        'Vivecon', 'RH', 'Tienetutela', 'Nivelestudio'
    ];

    public function estados()
    {
        return $this->belongsToMany('App\Modelos\Estado')->withPivot('Paciente_id', 'Estado_id', 'Actualizado_por')->withTimestamps();
    }

    public function citas()
    {
        return $this->hasMany('App\Modelos\Cita');
    }

    public function pqrsf()
    {
        return $this->hasMany('App\Modelos\Pqrsf');
    }

    public function antecedente()
    {
        return $this->hasMany('App\Modelos\Antecedente');
    }

    public function marcas()
    {
        return $this->hasMany('App\Modelos\Marca');
    }
}
