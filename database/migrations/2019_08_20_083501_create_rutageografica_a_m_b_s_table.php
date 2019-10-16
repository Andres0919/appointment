<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutageograficaAMBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutageografica_a_m_b_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('munorigen_id')->unsigned()->index();
            $table->foreign('munorigen_id')->references('id')->on('Municipios');
            $table->bigInteger('munopcion1_id')->unsigned()->index();
            $table->foreign('munopcion1_id')->references('id')->on('Municipios');
            $table->integer('valor_opc1');
            $table->bigInteger('munopcion2_id')->unsigned()->index();
            $table->foreign('munopcion2_id')->references('id')->on('Municipios');
            $table->integer('valor_opc2');
            $table->bigInteger('munopcion3_id')->unsigned()->index();
            $table->foreign('munopcion3_id')->references('id')->on('Municipios');
            $table->integer('valor_opc3');
            $table->bigInteger('munopcion4_id')->unsigned()->index();
            $table->foreign('munopcion4_id')->references('id')->on('Municipios');
            $table->integer('valor_opc4');
            $table->bigInteger('munopcion5_id')->unsigned()->index();
            $table->foreign('munopcion5_id')->references('id')->on('Municipios');
            $table->integer('valor_opc5');
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
        Schema::dropIfExists('rutageografica_a_m_b_s');
    }
}
