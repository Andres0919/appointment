<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConductasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conductas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Citapaciente_id');
            $table->string('Planmanejo')->nullable();
            $table->string('Recomendaciones')->nullable();
            $table->string('Destinopaciente');
            $table->string('Finalidad');
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
        Schema::dropIfExists('conductas');
    }
}
