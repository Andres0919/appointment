<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Agenda_id')->unsigned()->index();
            $table->foreign('Agenda_id')->references('id')->on('Agendas');
            $table->timestamp('Hora_Inicio')->nullable();
            $table->timestamp('Hora_Final')->nullable();
            $table->integer('Cantidad')->default('0');
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados'); //1 Estado disponible - 2 pendiente - 3 cancelada - 4 confirmada - 5 En consulta - 6 Atendida - 7 Bloqueada - 8 Reasignada - 9 inasistencia 
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
        Schema::dropIfExists('citas');
    }
}
