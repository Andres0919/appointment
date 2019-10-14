<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoPacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_paciente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Paciente_id')->unsigned()->index();
            $table->foreign('Paciente_id')->references('id')->on('Pacientes');
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados');
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
        Schema::dropIfExists('estado_paciente');
    }
}
