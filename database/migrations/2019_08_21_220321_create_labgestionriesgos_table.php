<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabgestionriesgosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labgestionriesgos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Citapaciente_id');
            $table->string('Glicemia')->nullable();
            $table->date('Glicemiafecha')->nullable();
            $table->string('Hemoglobinaglicosilada')->nullable();
            $table->date('Hemoglobinafecha')->nullable();
            $table->string('Colesteroltotal')->nullable();
            $table->date('Colesteroltotalfecha')->nullable();
            $table->string('Colesterolhdl')->nullable();
            $table->date('Colesterolhdlfecha')->nullable();
            $table->string('Colesterolldl')->nullable();
            $table->date('Colesterolldlfecha')->nullable();
            $table->string('Trigliceridos')->nullable();
            $table->date('Trigliceridosfecha')->nullable();
            $table->string('Proteinuria')->nullable();
            $table->date('Proteinuriafecha')->nullable();
            $table->string('Uroanalisis')->nullable();
            $table->date('Uroanalisisfecha')->nullable();
            $table->string('Microalbuminuria')->nullable();
            $table->date('Microalbuminuriafecha')->nullable();
            $table->string('Creatinina')->nullable();
            $table->date('Creatininafecha')->nullable();
            $table->string('Disminuciondetfg')->nullable();
            $table->string('Resultadoframinghan')->nullable();
            $table->string('Cumplemetaterapeutica')->nullable();
            $table->string('Pacienteadherente')->nullable();
            $table->string('Pacientecontrolado')->nullable();
            $table->string('Insulinorequiriente')->nullable();
            $table->string('Signosdealarma')->nullable();
            $table->string('Hospitalizacionesrecientes')->nullable();
            $table->string('Valoracionpornutricion')->nullable();
            $table->string('Valoracionporpsicologia')->nullable();
            $table->string('Asisteatallergrupaleducativo')->nullable();
            $table->string('Periodicidadproximocontrol')->nullable();
            $table->string('Proximocontrolcon')->nullable();
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
        Schema::dropIfExists('labgestionriesgos');
    }
}
