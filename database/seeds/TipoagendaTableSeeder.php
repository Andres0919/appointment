<?php

use App\Modelos\TipoAgenda;
use Illuminate\Database\Seeder;

class TipoagendaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAgenda::create([
            'name' => 'Consulta Externa'
        ]); 
        TipoAgenda::create([
            'name' => 'Atención Prioritaria'
        ]);  
        TipoAgenda::create([
            'name' => 'Consulta de PyP'
        ]);  
        TipoAgenda::create([
            'name' => 'Consulta Individual de Riesgo Cardiovascular '
        ]);  
        TipoAgenda::create([
            'name' => 'Procedimientos menores'
        ]); 
    }
}
