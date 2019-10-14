<?php

use Illuminate\Database\Seeder;
use App\Modelos\Departamento;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
                'codigo_Dane' => '5',
                'Nombre'    => 'ANTIOQUIA'
            ]);
            Departamento::create([
                'codigo_Dane' => '8',
                'Nombre'    => 'ATLANTICO'
            ]);
            Departamento::create([
                'codigo_Dane' => '11',
                'Nombre'    => 'BOGOTA'
            ]);
            Departamento::create([
                'codigo_Dane' => '13',
                'Nombre'    => 'BOLIVAR'
            ]);
            Departamento::create([
                'codigo_Dane' => '15',
                'Nombre'    => 'BOYACA'
            ]);
            Departamento::create([
                'codigo_Dane' => '17',
                'Nombre'    => 'CALDAS'
            ]);
            Departamento::create([
                'codigo_Dane' => '18',
                'Nombre'    => 'CAQUETA'
            ]);
            Departamento::create([
                'codigo_Dane' => '19',
                'Nombre'    => 'CAUCA'
            ]);
            Departamento::create([
                'codigo_Dane' => '20',
                'Nombre'    => 'CESAR'
            ]);
            Departamento::create([
                'codigo_Dane' => '23',
                'Nombre'    => 'CORDOBA'
            ]);
            Departamento::create([
                'codigo_Dane' => '25',
                'Nombre'    => 'CUNDINAMARCA'
            ]);
            Departamento::create([
                'codigo_Dane' => '27',
                'Nombre'    => 'CHOCO'
            ]);
            Departamento::create([
                'codigo_Dane' => '41',
                'Nombre'    => 'HUILA'
            ]);
            Departamento::create([
                'codigo_Dane' => '44',
                'Nombre'    => 'LA GUAJIRA'
            ]);
            Departamento::create([
                'codigo_Dane' => '47',
                'Nombre'    => 'MAGDALENA'
            ]);
            Departamento::create([
                'codigo_Dane' => '50',
                'Nombre'    => 'META'
            ]);
            Departamento::create([
                'codigo_Dane' => '52',
                'Nombre'    => 'NARIÐO'
            ]);
            Departamento::create([
                'codigo_Dane' => '54',
                'Nombre'    => 'N. DE SANTANDER'
            ]);
            Departamento::create([
                'codigo_Dane' => '63',
                'Nombre'    => 'QUINDIO'
            ]);
            Departamento::create([
                'codigo_Dane' => '66',
                'Nombre'    => 'RISARALDA'
            ]);
            Departamento::create([
                'codigo_Dane' => '68',
                'Nombre'    => 'SANTANDER'
            ]);
            Departamento::create([
                'codigo_Dane' => '70',
                'Nombre'    => 'SUCRE'
            ]);
            Departamento::create([
                'codigo_Dane' => '73',
                'Nombre'    => 'TOLIMA'
            ]);
            Departamento::create([
                'codigo_Dane' => '76',
                'Nombre'    => 'VALLE DEL CAUCA'
            ]);
            Departamento::create([
                'codigo_Dane' => '81',
                'Nombre'    => 'ARAUCA'
            ]);
            Departamento::create([
                'codigo_Dane' => '85',
                'Nombre'    => 'CASANARE'
            ]);
            Departamento::create([
                'codigo_Dane' => '86',
                'Nombre'    => 'PUTUMAYO'
            ]);
            Departamento::create([
                'codigo_Dane' => '88',
                'Nombre'    => 'SAN ANDRES'
            ]);
            Departamento::create([
                'codigo_Dane' => '91',
                'Nombre'    => 'AMAZONAS'
            ]);
            Departamento::create([
                'codigo_Dane' => '94',
                'Nombre'    => 'GUAINIA'
            ]);
            Departamento::create([
                'codigo_Dane' => '95',
                'Nombre'    => 'GUAVIARE'
            ]);
            Departamento::create([
                'codigo_Dane' => '97',
                'Nombre'    => 'VAUPES'
            ]);
            Departamento::create([
                'codigo_Dane' => '99',
                'Nombre'    => 'VICHADA'
            ]);      
    }
}
