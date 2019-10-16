<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitapatologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citapatologias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cita_id')->unsigned()->index();
            $table->foreign('Cita_id')->references('id')->on('Citas');
            $table->bigInteger('Cie10_id')->unsigned()->index();
            $table->foreign('Cie10_id')->references('id')->on('Cie10s');
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
        Schema::dropIfExists('citapatologias');
    }
}
