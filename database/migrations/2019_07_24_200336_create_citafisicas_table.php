<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitafisicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citafisicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cita_id')->unsigned()->index();
            $table->foreign('Cita_id')->references('id')->on('Citas');
            $table->bigInteger('Examenfisico_id')->unsigned()->index();
            $table->foreign('Examenfisico_id')->references('id')->on('Examenfisicos');
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
        Schema::dropIfExists('citafisicas');
    }
}
