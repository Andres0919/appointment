<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValormanualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valormanuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Codigomanual_id')->default('1')->unsigned()->index();
            $table->foreign('Codigomanual_id')->references('id')->on('Codigomanuals');
            $table->integer('Valor');
            $table->integer('Anio');
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
        Schema::dropIfExists('valormanuals');
    }
}
