<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCie10sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cie10s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Capitulo')->nullable();
            $table->string('Nombre_Capitulo')->nullable();
            $table->string('Codigo_CIE10')->nullable();
            $table->string('Descripcion', 1000)->nullable();
            $table->string('Limitada_Sexo')->nullable();
            $table->string('Inferior_edad')->nullable();
            $table->string('Superior_edad')->nullable();
            $table->string('Visible')->nullable();
            $table->string('Nombre')->nullable();
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
        Schema::dropIfExists('cie10s');
    }
}
