<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Tiporden_id')->unsigned()->index();
            $table->foreign('Tiporden_id')->references('id')->on('Tipordens');
            $table->bigInteger('Cita_id')->unsigned()->index();
            $table->foreign('Cita_id')->references('id')->on('cita_paciente');
            $table->bigInteger('Usuario_id')->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('Users');
            $table->string('paginacion')->nullable()->index();
            $table->bigInteger('Estado_id')->unsigned()->index();
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
        Schema::dropIfExists('ordens');
    }
}
