<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncapacidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('Fechainicio');
            $table->integer('Dias');
            $table->date('Fechafinal');
            $table->string('Prorroga')->nullable();
            $table->string('Adjuntoincapacidad')->nullable();
            $table->bigInteger('Orden_id')->unsigned()->index();
            $table->foreign('Orden_id')->references('id')->on('Ordens');
            $table->bigInteger('Cie10_id')->unsigned()->index();
            $table->foreign('Cie10_id')->references('id')->on('Cie10s');
            $table->bigInteger('Usuarioordena_id')->unsigned()->index();
            $table->foreign('Usuarioordena_id')->references('id')->on('Users');
            $table->bigInteger('Usuarioedit_id')->nullable()->unsigned()->index();
            $table->foreign('Usuarioedit_id')->references('id')->on('Users');
            $table->string('Laboraen')->nullable();
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
        Schema::dropIfExists('incapacidades');
    }
}
