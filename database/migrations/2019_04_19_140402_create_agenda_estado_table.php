<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaEstadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_estado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Agenda_id')->unsigned()->index();
            $table->foreign('Agenda_id')->references('id')->on('Agendas');
            $table->bigInteger('User_id')->unsigned()->index();
            $table->foreign('User_id')->references('id')->on('users');
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
        Schema::dropIfExists('agenda_estado');
    }
}
