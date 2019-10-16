<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdencomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordencompras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Cantidad');
            $table->bigInteger('Bodegarticulo_id')->unsigned()->index();
            $table->foreign('Bodegarticulo_id')->references('id')->on('bodegarticulos');
            $table->bigInteger('Prestador_id')->nullable()->unsigned()->index();
            $table->foreign('Prestador_id')->references('id')->on('Prestadores');
            $table->bigInteger('Usuario_id')->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('Users');
            $table->bigInteger('Usuarioresponde_id')->nullable()->unsigned()->index();
            $table->foreign('Usuarioresponde_id')->references('id')->on('Users');
            $table->bigInteger('Estado_id')->default('15')->unsigned()->index();
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
        Schema::dropIfExists('ordencompras');
    }
}
