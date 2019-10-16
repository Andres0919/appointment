<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipotransacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipotransacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Transacion_id')->nullable()->unsigned()->index();
            $table->foreign('Transacion_id')->references('id')->on('Transacions');
            $table->bigInteger('Tipo_id')->nullable()->unsigned()->index();
            $table->foreign('Tipo_id')->references('id')->on('Tipos');
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
        Schema::dropIfExists('tipotransacions');
    }
}
