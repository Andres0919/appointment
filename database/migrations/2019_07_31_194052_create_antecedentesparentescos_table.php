<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedentesparentescosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentesparentescos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Parentesco_id')->unsigned()->index();
            $table->foreign('Parentesco_id')->references('id')->on('Parentescos');
            $table->bigInteger('Parentescotecedentes_id')->unsigned()->index();
            $table->foreign('Parentescotecedentes_id')->references('id')->on('ParentescoAntecedentes');
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
        Schema::dropIfExists('antecedentesparentescos');
    }
}
