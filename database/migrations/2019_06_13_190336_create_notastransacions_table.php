<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotastransacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notastransacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Usuario_id')->nullable()->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('users');
            $table->bigInteger('Movimiento_id')->nullable()->unsigned()->index();
            $table->foreign('Movimiento_id')->references('id')->on('Movimientos');
            $table->string('Descripcion')->nullable();
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
        Schema::dropIfExists('notastransacions');
    }
}
