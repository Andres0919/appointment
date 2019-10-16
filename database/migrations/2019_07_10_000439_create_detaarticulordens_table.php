<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetaarticulordensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detaarticulordens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Orden_id')->unsigned()->index();
            $table->foreign('Orden_id')->references('id')->on('Ordens');
            $table->bigInteger('codesumi_id')->unsigned()->index();
            $table->foreign('codesumi_id')->references('id')->on('codesumis');
            $table->string('Cantidadosis')->nullable();
            $table->string('Via')->nullable();
            $table->string('Unidadmedida')->nullable();
            $table->integer('Frecuencia')->nullable();
            $table->string('Unidadtiempo')->nullable();
            $table->integer('Duracion')->nullable();
            $table->integer('Cantidadmensual')->nullable();
            $table->integer('Cantidadmensualdisponible')->nullable();
            $table->integer('NumMeses')->nullable();
            $table->string('Observacion', 500)->nullable();
            $table->string('Cantidadpormedico')->nullable();
            $table->bigInteger('Estado_id')->default('3')->unsigned()->index();
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
        Schema::dropIfExists('detaarticulordens');
    }
}
