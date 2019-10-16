<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentescoantecedentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parentescoantecedentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Antecedente_id')->unsigned()->index();
            $table->foreign('Antecedente_id')->references('id')->on('Antecedentes');
            $table->bigInteger('Citapaciente_id')->unsigned()->index();
            $table->foreign('Citapaciente_id')->references('id')->on('cita_paciente');
            $table->bigInteger('Usuario_id')->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('Users');
            $table->string('Descripcion', 500)->nullable();
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
        Schema::dropIfExists('parentescoantecedentes');
    }
}
