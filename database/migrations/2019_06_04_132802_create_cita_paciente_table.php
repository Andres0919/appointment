<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitaPacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_paciente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Paciente_id')->nullable()->unsigned()->index();
            $table->foreign('Paciente_id')->references('id')->on('Pacientes');
            $table->bigInteger('Cita_id')->nullable()->unsigned()->index();
            $table->foreign('Cita_id')->references('id')->on('Citas');
            $table->bigInteger('Usuario_id')->nullable()->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('users');
            $table->bigInteger('Tipocita_id')->nullable()->unsigned()->index();
            $table->foreign('Tipocita_id')->references('id')->on('Tipocitas');
            $table->string('Fecha_solicita')->nullable();
            $table->string('Motivoconsulta', 500)->nullable();
            $table->string('Enfermedadactual', 500)->nullable();
            $table->string('Resultayudadiagnostica', 500)->nullable();
            $table->string('Oftalmologico')->nullable();
            $table->string('Genitourinario')->nullable();
            $table->string('Otorrinoralingologico')->nullable();
            $table->string('Linfatico')->nullable();
            $table->string('Osteomioarticular')->nullable();
            $table->string('Neurologico')->nullable();
            $table->string('Cardiovascular')->nullable();
            $table->string('Tegumentario')->nullable();
            $table->string('Respiratorio')->nullable();
            $table->string('Endocrinologico')->nullable();
            $table->string('Gastrointestinal')->nullable();
            $table->string('Norefiere')->nullable();
            $table->string('Timeconsulta')->nullable();
            $table->string('Medicoordeno')->nullable();
            $table->string('Entidademite')->nullable();
            $table->string('Finalidad')->nullable();
            $table->string('observaciones', 1000)->nullable();
            $table->bigInteger('Estado_id')->default('3')->unsigned()->index();
            $table->foreign('Estado_id')->references('id')->on('Estados'); //1 Estado disponible - 2 pendiente - 3 cancelada - 4 En consulta - 5 Atendida - 6 Bloqueada - 7 Reasignada - 8 inasistencia 
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
        Schema::dropIfExists('cita_paciente');
    }
}