<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Codigo')->nullable();
            $table->string('Nombre', 1000)->nullable();
            $table->string('Genero')->nullable();
            $table->string('EdadInicial')->nullable();
            $table->string('EdadFinal')->nullable();
            $table->string('Archivo')->nullable();
            $table->string('Qx')->nullable();
            $table->string('Dxrequerido')->nullable();
            $table->string('Nivelordenamiento')->nullable();
            $table->string('Requiere_auditoria')->nullable();
            $table->string('Peridiocidad')->nullable();
            $table->string('Ambito')->nullable();
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
        Schema::dropIfExists('cups');
    }
}
