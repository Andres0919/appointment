<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Numfacturazeus')->nullable();
            $table->string('Numfactura')->nullable();
            $table->bigInteger('Tipotransacion_id')->nullable()->unsigned()->index();
            $table->foreign('Tipotransacion_id')->references('id')->on('Tipotransacions');
            $table->bigInteger('prestador_id')->nullable()->unsigned()->index();
            $table->foreign('prestador_id')->references('id')->on('prestadores');
            $table->bigInteger('BodegaOrigen_id')->nullable()->unsigned()->index();
            $table->foreign('BodegaOrigen_id')->references('id')->on('Bodegas');
            $table->bigInteger('BodegaDestino_id')->nullable()->unsigned()->index();
            $table->foreign('BodegaDestino_id')->references('id')->on('Bodegas');
            $table->bigInteger('Orden_id')->nullable()->unsigned()->index();
            $table->foreign('Orden_id')->references('id')->on('Ordens');
            $table->bigInteger('Reps_id')->nullable()->unsigned()->index();
            $table->foreign('Reps_id')->references('id')->on('Reps');
            $table->bigInteger('Estado_id')->default('4')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados');
            $table->bigInteger('usuario_id')->nullable()->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('users');
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
        Schema::dropIfExists('movimientos');
    }
}
