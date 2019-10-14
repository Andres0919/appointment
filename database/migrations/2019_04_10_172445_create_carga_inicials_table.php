<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaInicialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_inicials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Region')->nullable();
            $table->string('UT')->nullable();
            $table->string('Primer_Nom')->nullable();
            $table->string('SegundoNom')->nullable();
            $table->string('Primer_Ape')->nullable();
            $table->string('Segundo_Ape')->nullable();
            $table->string('Tipo_Doc')->nullable();
            $table->string('Num_Doc')->nullable();
            $table->string('Sexo')->nullable();
            $table->string('Fecha_Afilia')->nullable();
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
            $table->string('Estado_Afilia')->nullable();
            $table->string('Dane_Mpio')->nullable();
            $table->string('Mpio_Afilia')->nullable();
            $table->string('Dane_Dpto')->nullable();
            $table->string('Departamento')->nullable();
            $table->string('Subregion')->nullable();
            $table->string('Dpto_Atencion')->nullable();
            $table->string('Mpio_Atencion')->nullable();
            $table->string('IPS')->nullable();
            $table->string('Sede_Odontologica')->nullable();
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
        Schema::dropIfExists('carga_inicials');
    }
}
