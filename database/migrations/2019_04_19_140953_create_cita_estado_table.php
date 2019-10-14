<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitaEstadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_estado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados');
            $table->bigInteger('Cita_id')->unsigned()->index();
            $table->foreign('Cita_id')->references('id')->on('Citas');
            $table->bigInteger('Actualizado_por')->unsigned()->index();
            $table->foreign('Actualizado_por')->references('id')->on('users');
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
        Schema::dropIfExists('cita_estado');
    }
}
