<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodepropiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codepropios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Codigo');
            $table->string('Descripcion'); 
            $table->integer('Valor'); 
            $table->bigInteger('Codesumi_id')->unsigned()->index();
            $table->foreign('Codesumi_id')->references('id')->on('Codesumis');
            $table->bigInteger('sedeproveedor_id')->unsigned()->index();
            $table->foreign('sedeproveedor_id')->references('id')->on('sedeproveedores');
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados'); //1 Estado activo 2 inhabilitado
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
        Schema::dropIfExists('codepropios');
    }
}
