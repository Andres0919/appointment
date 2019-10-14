<?php

use Illuminate\Database\Seeder;
use App\Modelos\Sede;

class SedeTableSeeder extends Seeder
{
    public function run()
    {
        Sede::create([
            'Municipio_id' => '59',
            'Nombre' => 'ITAGUI',
            'Direccion' => 'CR 49 #51 40',
            'Telefono' => '5201040 EXT 8',
            'Nit' => '90003371',
        ]);
    }
}
