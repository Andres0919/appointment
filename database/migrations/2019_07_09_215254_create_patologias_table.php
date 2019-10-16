<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patologias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Hipearterial')->nullable();
            $table->string('Diabetes')->nullable();
            $table->string('Isquemicacorazon')->nullable();
            $table->string('Trastornocoagulacion')->nullable();
            $table->string('Cancer')->nullable();
            $table->string('Insufrenalcronica')->nullable();
            $table->string('Asma')->nullable();
            $table->string('Epoc')->nullable();
            $table->string('Tiroides')->nullable();
            $table->string('Trastornotractodigestivo')->nullable();
            $table->string('Epilepsia')->nullable();
            $table->string('Trastornopsiquiatrico')->nullable();
            $table->string('Vih')->nullable();
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
        Schema::dropIfExists('patologias');
    }
}
