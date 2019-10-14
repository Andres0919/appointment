<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallecitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Usuario_id')->nullable()->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('users');
            $table->bigInteger('Citapaciente_id')->nullable()->unsigned()->index();
            $table->foreign('Citapaciente_id')->references('id')->on('cita_paciente');
            $table->string('Motivo')->nullable();
            $table->bigInteger('Estado_id')->nullable()->unsigned()->index();
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
        Schema::dropIfExists('detallecitas');
    }
}
