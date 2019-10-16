<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSedeproveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedeproveedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Municipio_id')->nullable()->unsigned()->index();
            $table->foreign('Municipio_id')->references('id')->on('Municipios');
            $table->bigInteger('Prestador_id')->nullable()->unsigned()->index();
            $table->foreign('Prestador_id')->references('id')->on('Prestadores');
            $table->string('Codigo_habilitacion');
            $table->string('Nombre');
            $table->string('Nivelatencion');
            $table->string('Correo1');
            $table->string('Correo2')->nullable();
            $table->string('Telefono1');
            $table->string('Telefono2')->nullable();
            $table->string('Direccion')->nullable();
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
        Schema::dropIfExists('sedeproveedores');
    }
}
