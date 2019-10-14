<?php

use Illuminate\Database\Seeder;
use App\Modelos\Consultorio;

class ConsultorioTableSeeder extends Seeder
{
    public function run()
    {
        Consultorio::create([
            'Sede_id' => '1',
            'Nombre' => 'Consultorio 1',
            'Descripcion' => '4',
            'Cantidad' => '1'
        ]);

        Consultorio::create([
            'Sede_id' => '1',
            'Nombre' => 'Consultorio 2',
            'Descripcion' => '4',
            'Cantidad' => '1'
        ]);

        Consultorio::create([
            'Sede_id' => '1',
            'Nombre' => 'Consultorio 3',
            'Descripcion' => '4',
            'Cantidad' => '1'
        ]);

        Consultorio::create([
            'Sede_id' => '1',
            'Nombre' => 'Auditorio',
            'Descripcion' => '4',
            'Cantidad' => '20'
        ]);
    }
}
