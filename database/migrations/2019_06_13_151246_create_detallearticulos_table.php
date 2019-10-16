<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallearticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallearticulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Subgrupo_id')->nullable()->unsigned()->index();
            $table->foreign('Subgrupo_id')->references('id')->on('Subgrupos');
            $table->bigInteger('Codesumi_id')->nullable()->unsigned()->index();
            $table->foreign('Codesumi_id')->references('id')->on('Codesumis');
            $table->string('Expediente')->nullable();
            $table->string('Producto')->nullable();
            $table->string('Titular')->nullable();
            $table->string('Registro_Sanitario')->nullable();
            $table->string('Invima')->nullable();
            $table->string('Fecha_Expedicion')->nullable();
            $table->string('Fecha_Vencimiento')->nullable();
            $table->string('Estado_Registro')->nullable();
            $table->string('Expediente_Cum')->nullable();
            $table->string('Consecutivo')->nullable();
            $table->string('Cantidad_Cum')->nullable();
            $table->string('Descripcion_Comercial', 1000)->nullable();
            $table->string('Estado_Cum')->nullable();
            $table->string('Fecha_Activo')->nullable();
            $table->string('Fecha_Inactivo')->nullable();
            $table->string('Muestra_Medica')->nullable();
            $table->string('Unidad')->nullable();
            $table->string('Atc')->nullable();
            $table->string('Descripcion_Atc')->nullable();
            $table->string('Via_Administracion')->nullable();
            $table->string('Concentracion')->nullable();
            $table->string('Principio_Activo', 1000)->nullable();
            $table->string('Unidad_Medida')->nullable();
            $table->string('Cantidad')->nullable();
            $table->string('Unidad_Referencia')->nullable();
            $table->string('Forma_Farmaceutica')->nullable();
            $table->string('Cum_Validacion')->nullable();
            $table->string('CUM_completo')->nullable();
            $table->string('Activo_HORUS')->nullable();
            $table->string('Regulado')->nullable();
            $table->double('Precio_maximo')->nullable();
            $table->string('Unidad_aux')->nullable();
            $table->string('POS')->nullable();
            $table->string('Alto_Costo')->nullable();
            $table->string('Acuerdo_228')->nullable();
            $table->string('Nivel_Ordenamiento')->nullable();
            $table->string('Requiere_autorizacion')->nullable();
            $table->integer('Cantidadmaxordenar')->nullable();
            $table->integer('Frecuencia')->nullable();
            $table->string('Nombresumi', 1000)->nullable();
            $table->bigInteger('Estado_id')->default('3')->unsigned()->index();
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
        Schema::dropIfExists('detallearticulos');
    }
}
