<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegatransacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegatransacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Lote_id')->nullable()->unsigned()->index();
            $table->foreign('Lote_id')->references('id')->on('Lotes');
            $table->bigInteger('Movimiento_id')->nullable()->unsigned()->index();
            $table->foreign('Movimiento_id')->references('id')->on('Movimientos');
            $table->bigInteger('Bodegarticulo_id')->nullable()->unsigned()->index();
            $table->foreign('Bodegarticulo_id')->references('id')->on('Bodegarticulos');
            $table->bigInteger('Cantidadtotal');
            $table->bigInteger('CantidadtotalFactura');
            $table->bigInteger('Cantidadtotalinventario');
            $table->bigInteger('Precio')->nullable();
            $table->bigInteger('Valor')->default('0');
            $table->bigInteger('Valortotal');
            $table->decimal('Valorpromedio', 10, 2)->nullable();
            $table->bigInteger('Estado_id')->default('4')->unsigned()->index();
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
        Schema::dropIfExists('bodegatransacions');
    }
}
