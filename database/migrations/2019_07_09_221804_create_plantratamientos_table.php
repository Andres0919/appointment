<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantratamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantratamientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Resultadolab')->nullable();
            $table->string('Plantratamiento')->nullable();
            $table->string('Destinopaciente')->nullable();
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
        Schema::dropIfExists('plantratamientos');
    }
}
