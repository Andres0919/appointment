<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCie10pacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cie10pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cie10_id')->unsigned()->index();
            $table->foreign('Cie10_id')->references('id')->on('Cie10s');
            $table->bigInteger('Citapaciente_id')->unsigned()->index();
            $table->foreign('Citapaciente_id')->references('id')->on('cita_paciente');
            $table->boolean('Esprimario')->nullable();
            $table->string('Tipodiagnostico')->nullable();
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
        Schema::dropIfExists('cie10pacientes');
    }
}
