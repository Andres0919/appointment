<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Medico_id')->unsigned()->index();
            $table->foreign('Medico_id')->references('id')->on('users');
            $table->bigInteger('Agenda_id')->unsigned()->index();
            $table->foreign('Agenda_id')->references('id')->on('Agendas');
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
        Schema::dropIfExists('estado_user');
    }
}
