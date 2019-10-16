<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesumisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codesumis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre');
            $table->string('Codigo');
            $table->string('Frecuencia')->nullable();
            $table->string('Cantidadmaxordenar')->nullable();
            $table->string('Requiere_autorizacion')->nullable();
            $table->string('Nivel_Ordenamiento')->nullable();
            $table->string('Unidad_aux')->nullable();
            $table->bigInteger('Tipocodesumi_id')->default('1')->unsigned()->index();
            $table->foreign('Tipocodesumi_id')->references('id')->on('Tipocodigos');//  1 medicamentos 2 tarifario Falta por crear la tabla maestra
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados'); //   1 Estado activo 2 inhabilitado
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
        Schema::dropIfExists('codesumis');
    }
}
