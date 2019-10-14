<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Region')->nullable();
            $table->string('Ut')->nullable();
            $table->string('Primer_Nom')->nullable();
            $table->string('SegundoNom')->nullable();
            $table->string('Primer_Ape')->nullable();
            $table->string('Segundo_Ape')->nullable();
            $table->string('Tipo_Doc')->nullable();
            $table->string('Num_Doc')->nullable();
            $table->string('Sexo')->nullable();
            $table->string('Fecha_Afiliado')->nullable();
            $table->string('Fecha_Naci')->nullable();
            $table->string('Edad_Cumplida')->nullable();
            $table->string('Discapacidad')->nullable();
            $table->string('Grado_Discapacidad')->nullable();
            $table->string('Tipo_Afiliado')->nullable();
            $table->string('Orden_Judicial')->nullable();
            $table->string('Num_Folio')->nullable();
            $table->string('Fecha_Emision')->nullable();
            $table->string('Parentesco')->nullable();
            $table->string('TipoDoc_Cotizante')->nullable();
            $table->string('Doc_Cotizante')->nullable();
            $table->string('Tipo_Cotizante')->nullable();
            $table->string('Estado_Afiliado')->nullable();
            $table->string('Dane_Mpio')->nullable();
            $table->string('Mpio_Afiliado')->nullable();
            $table->string('Dane_Dpto')->nullable();
            $table->string('Departamento')->nullable();
            $table->string('Subregion')->nullable();
            $table->string('Dpto_Atencion')->nullable();
            $table->string('Mpio_Atencion')->nullable();
            $table->string('IPS')->nullable();
            $table->string('Sede_Odontologica')->nullable();
            $table->string('Medicofamilia')->nullable();
            $table->string('Etnia')->nullable();
            $table->string('Nivel_Sisben')->nullable();
            $table->string('Laboraen')->nullable();
            $table->string('Mpio_Labora')->nullable();
            $table->string('Direccion_Residencia')->nullable();
            $table->string('Mpio_Residencia')->nullable();
            $table->string('Telefono')->nullable();
            $table->string('Correo')->nullable();
            $table->string('Estrato')->nullable();
            $table->string('Celular')->nullable();
            $table->string('Sexo_Biologico')->nullable();
            $table->string('Tipo_Regimen')->nullable();
            $table->string('Num_Hijos')->nullable();
            $table->string('Vivecon')->nullable();
            $table->string('RH')->nullable();
            $table->boolean('Tienetutela')->nullable();
            $table->string('Nivelestudio', 300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
