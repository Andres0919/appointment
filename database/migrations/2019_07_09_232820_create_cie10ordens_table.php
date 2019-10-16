<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCie10ordensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cie10ordens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cie10_id')->unsigned()->index();
            $table->foreign('Cie10_id')->references('id')->on('Cie10s');
            $table->bigInteger('Orden_id')->unsigned()->index();
            $table->foreign('Orden_id')->references('id')->on('Ordens');
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
        Schema::dropIfExists('cie10ordens');
    }
}
