<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Numlote');
            $table->date('Fvence');
            $table->integer('Cantidadisponible');
            $table->bigInteger('Bodegarticulo_id')->nullable()->unsigned()->index();
            $table->foreign('Bodegarticulo_id')->references('id')->on('Bodegarticulos');
            $table->bigInteger('Estado_id')->nullable()->unsigned()->index();
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
        Schema::dropIfExists('lotes');
    }
}
