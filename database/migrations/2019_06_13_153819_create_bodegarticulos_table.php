<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegarticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegarticulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Bodega_id')->nullable()->unsigned()->index();
            $table->foreign('Bodega_id')->references('id')->on('Bodegas');
            $table->bigInteger('Detallearticulo_id')->nullable()->unsigned()->index();
            $table->foreign('Detallearticulo_id')->references('id')->on('Detallearticulos');
            $table->integer('Stock');
            $table->integer('Cantidadmaxima');
            $table->integer('Cantidadminima');
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
        Schema::dropIfExists('bodegarticulos');
    }
}
