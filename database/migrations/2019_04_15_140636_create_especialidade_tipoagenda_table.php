<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialidadeTipoagendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidade_tipoagenda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Especialidad_id')->nullable()->unsigned()->index();
            $table->foreign('Especialidad_id')->references('id')->on('Especialidades');
            $table->bigInteger('Tipoagenda_id')->nullable()->unsigned()->index();
            $table->foreign('Tipoagenda_id')->references('id')->on('Tipo_agendas');
            $table->integer('Duracion');
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
        Schema::dropIfExists('especialidade_tipoagenda');
    }
}
