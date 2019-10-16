<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cup_id')->unsigned()->index();
            $table->foreign('Cup_id')->references('id')->on('Cups');
            $table->bigInteger('Sedeproveedor_id')->unsigned()->index();
            $table->foreign('Sedeproveedor_id')->references('id')->on('Sedeproveedores');
            $table->string('Fechainicio');
            $table->string('Fechafinal');
            $table->string('Tarifa');
            $table->string('Manual')->nullable();
            $table->string('Ambito')->nullable();
            $table->integer('Valor');
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
        Schema::dropIfExists('tarifarios');
    }
}
