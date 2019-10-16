<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Citapaciente_id');
            $table->string('Fechaultimamenstruacion')->nullable();
            $table->string('Gestaciones')->nullable();
            $table->string('Partos')->nullable();
            $table->string('Abortoprovocado')->nullable();
            $table->string('Abortoespontaneo')->nullable();
            $table->string('Mortinato')->nullable();
            $table->string('Gestantefechaparto')->nullable();
            $table->string('Gestantenumeroctrlprenatal')->nullable();
            $table->string('Eutoxico')->nullable();
            $table->string('Cesaria')->nullable();
            $table->string('Cancercuellouterino')->nullable();
            $table->string('Ultimacitologia')->nullable();
            $table->string('Resultado')->nullable();
            $table->string('Menarquia')->nullable();
            $table->string('Ciclos')->nullable();
            $table->string('Regulares')->nullable();
            $table->string('Observaciongineco')->nullable();
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
        Schema::dropIfExists('ginecologicos');
    }
}
