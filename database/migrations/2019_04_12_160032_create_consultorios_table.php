<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Sede_id')->unsigned()->index();
            $table->foreign('Sede_id')->references('id')->on('sedes');
            $table->string('Nombre');
            $table->string('Descripcion')->nullable();
            $table->string('Cantidad')->nullable();
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
        Schema::dropIfExists('consultorios');
    }
}
