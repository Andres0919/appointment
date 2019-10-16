<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotivosTable extends Migration
{

    public function up()
    {
        Schema::create('motivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Citapaciente_id')->unsigned()->index();
            $table->foreign('Citapaciente_id')->references('id')->on('cita_paciente');
            $table->bigInteger('Usuariosuspende_id')->unsigned()->index();
            $table->foreign('Usuariosuspende_id')->references('id')->on('Users');
            $table->string('Motivo', 1000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motivos');
    }
}
