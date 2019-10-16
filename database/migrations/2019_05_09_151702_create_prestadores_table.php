<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Tipoprestador_id')->unsigned()->index();
            $table->foreign('Tipoprestador_id')->references('id')->on('Tipoprestadors');
            $table->string('Nombre');
            $table->string('Nit');
            $table->string('Direccion');
            $table->string('Correo1');
            $table->string('Correo2')->nullable();
            $table->string('Telefono1');
            $table->string('Telefono2')->nullable();
            $table->string('Codigo_prestador')->nullable();
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados');
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
        Schema::dropIfExists('prestadores');
    }
}
