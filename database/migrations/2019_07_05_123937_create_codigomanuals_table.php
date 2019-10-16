<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodigomanualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigomanuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Tipomanual_id')->default('1')->unsigned()->index();
            $table->foreign('Tipomanual_id')->references('id')->on('Tipomanuales');
            $table->bigInteger('Cup_id')->nullable()->unsigned()->index();
            $table->foreign('Cup_id')->references('id')->on('Cups');
            $table->string('Codigo');
            $table->string('Descripcion', 1000)->nullable();
            $table->integer('Valor');
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
        Schema::dropIfExists('codigomanuals');
    }
}
