<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacicolegiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacicolegios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Paciente_id')->unsigned()->index();
            $table->foreign('Paciente_id')->references('id')->on('Pacientes');
            $table->bigInteger('Colegio_id')->unsigned()->index();
            $table->foreign('Colegio_id')->references('id')->on('Colegios');
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
        Schema::dropIfExists('pacicolegios');
    }
}
