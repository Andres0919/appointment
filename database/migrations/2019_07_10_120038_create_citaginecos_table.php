<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitaginecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citaginecos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cita_id')->unsigned()->index();
            $table->foreign('Cita_id')->references('id')->on('Citas');
            $table->bigInteger('Ginecologia_id')->unsigned()->index();
            $table->foreign('Ginecologia_id')->references('id')->on('Ginecologicos');
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
        Schema::dropIfExists('citaginecos');
    }
}
