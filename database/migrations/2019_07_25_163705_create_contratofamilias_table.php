<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratofamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratofamilias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Contrato_id')->unsigned()->index();
            $table->foreign('Contrato_id')->references('id')->on('Contratos');
            $table->bigInteger('Familia_id')->unsigned()->index();
            $table->foreign('Familia_id')->references('id')->on('Familias');
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
        Schema::dropIfExists('contratofamilias');
    }
}
