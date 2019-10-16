<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupfamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupfamilias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cup_id')->unsigned()->index();
            $table->foreign('Cup_id')->references('id')->on('Cups');
            $table->bigInteger('Familia_id')->unsigned()->index();
            $table->foreign('Familia_id')->references('id')->on('Familias');
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
        Schema::dropIfExists('cupfamilias');
    }
}
