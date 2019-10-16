<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Municipio_id')->nullable()->unsigned()->index();
            $table->foreign('Municipio_id')->references('id')->on('Municipios');
            $table->bigInteger('Tipobodega_id')->nullable()->unsigned()->index();
            $table->foreign('Tipobodega_id')->references('id')->on('Tipobodegas');
            $table->string('Nombre');
            $table->string('Telefono')->nullable();
            $table->string('Direccion');
            $table->string('Horainicio');
            $table->string('Horafin');
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
        Schema::dropIfExists('bodegas');
    }
}
