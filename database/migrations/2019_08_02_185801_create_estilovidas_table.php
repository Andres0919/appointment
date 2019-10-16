<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstilovidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estilovidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Citapaciente_id');
            $table->string('Dietasaludable')->nullable();
            $table->string('Suenoreparador')->nullable();
            $table->string('Duermemenoseishoras')->nullable();
            $table->string('Altonivelestres')->nullable();
            $table->string('Actividadfisica')->nullable();
            $table->string('Frecuenciasemana')->nullable();
            $table->string('Duracion')->nullable();
            $table->string('Fumacantidad')->nullable();
            $table->string('Fumainicio')->nullable();
            $table->string('Fumadorpasivo')->nullable();
            $table->string('Cantidadlicor')->nullable();
            $table->string('Licorfrecuencia')->nullable();
            $table->string('Consumopsicoactivo')->nullable();
            $table->string('Psicoactivocantidad')->nullable();
            $table->string('Estilovidaobservaciones')->nullable();
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
        Schema::dropIfExists('estilovidas');
    }
}
