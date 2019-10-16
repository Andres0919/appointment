<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupordensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupordens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Orden_id')->unsigned()->index();
            $table->foreign('Orden_id')->references('id')->on('Ordens');
            $table->bigInteger('Cup_id')->unsigned()->index();
            $table->foreign('Cup_id')->references('id')->on('Cups');
            $table->integer('Cantidad')->default('1');
            $table->bigInteger('Ubicacion_id')->nullable()->unsigned()->index();
            $table->foreign('Ubicacion_id')->references('id')->on('Sedeproveedores');
            $table->bigInteger('Estado_id')->unsigned()->index();
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
        Schema::dropIfExists('cupordens');
    }
}
