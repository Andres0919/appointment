<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadcargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividadcargos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Cargo_id')->nullable()->unsigned()->index();
            $table->foreign('Cargo_id')->references('id')->on('Cargos');
            $table->string('Nombre');
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
        Schema::dropIfExists('actividadcargos');
    }
}
