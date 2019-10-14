<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre');
            $table->string('Direccion');
            $table->string('Telefono');
            $table->string('Nit');
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados'); //1 Estado activo 2 inhabilitado
            $table->bigInteger('Municipio_id')->unsigned()->index();
            $table->foreign('Municipio_id')->references('id')->on('Municipios');
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
        Schema::dropIfExists('sedes');
    }
}
