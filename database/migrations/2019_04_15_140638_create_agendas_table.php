<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Consultorio_id')->unsigned()->index();
            $table->foreign('Consultorio_id')->references('id')->on('Consultorios');
            $table->bigInteger('Especialidad_id')->unsigned()->index();
            $table->foreign('Especialidad_id')->references('id')->on('especialidade_tipoagenda');
            $table->bigInteger('Usuariocrea_id')->unsigned()->index();
            $table->foreign('Usuariocrea_id')->references('id')->on('users');
            $table->date('Fecha');
            $table->timestamp('Hora_Inicio')->nullable();
            $table->timestamp('Hora_Final')->nullable();
            $table->bigInteger('Estado_id')->default('3')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados'); //1 Estado activo 2 inhabilitado
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
        Schema::dropIfExists('agendas');
    }
}
