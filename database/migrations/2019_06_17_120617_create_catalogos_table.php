<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Detallearticulo_id')->nullable()->unsigned()->index();
            $table->foreign('Detallearticulo_id')->references('id')->on('Detallearticulos');
            $table->bigInteger('Prestador_id')->nullable()->unsigned()->index();
            $table->foreign('Prestador_id')->references('id')->on('Prestadores');
            $table->string('Valor')->nullanle();
            $table->string('Iva')->nullanle();
            $table->string('Valortotal')->nullanle();
            $table->bigInteger('Estado_id')->default('1')->unsigned()->index();
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
        Schema::dropIfExists('catalogos');
    }
}
