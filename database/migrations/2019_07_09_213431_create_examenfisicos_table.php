<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenfisicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examenfisicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Citapaciente_id');
            $table->integer('Peso')->nullable();
            $table->integer('Talla')->nullable();
            $table->integer('Imc')->nullable();
            $table->string('Clasificacion')->nullable();
            $table->integer('Perimetroabdominal')->nullable();
            $table->integer('Perimetrocefalico')->nullable();
            $table->double('Frecucardiaca')->nullable();
            $table->double('Pulsos')->nullable();
            $table->double('Frecurespiratoria')->nullable();
            $table->double('Temperatura')->nullable();
            $table->double('Saturacionoxigeno')->nullable();
            $table->string('Posicion')->nullable();
            $table->string('Lateralidad')->nullable();
            $table->integer('Presionsistolica')->nullable();
            $table->integer('Presiondiastolica')->nullable();
            $table->double('Presionarterialmedia')->nullable();
            $table->string('Condiciongeneral')->nullable();
            $table->string('Cabezacuello')->nullable();
            $table->string('Ojosfondojos')->nullable();
            $table->string('Agudezavisual')->nullable();
            $table->string('Cardiopulmonar')->nullable();
            $table->string('Abdomen')->nullable();
            $table->string('Osteomuscular')->nullable();
            $table->string('Extremidades')->nullable();
            $table->string('Pulsosperifericos')->nullable();
            $table->string('Neurologico')->nullable();
            $table->string('Reflejososteotendinos')->nullable();
            $table->string('Pielfraneras')->nullable();
            $table->string('Genitourinario')->nullable();
            $table->string('Examenmama')->nullable();
            $table->string('Tactoretal')->nullable();
            $table->string('Examenmental')->nullable();
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
        Schema::dropIfExists('examenfisicos');
    }
}
