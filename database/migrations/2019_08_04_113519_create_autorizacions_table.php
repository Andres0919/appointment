<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Articulorden_id')->nullable()->unsigned()->index();
            $table->foreign('Articulorden_id')->references('id')->on('Detaarticulordens');
            $table->bigInteger('Cuporden_id')->nullable()->unsigned()->index();
            $table->foreign('Cuporden_id')->references('id')->on('Cupordens');
            $table->bigInteger('Usuario_id')->unsigned()->index();
            $table->foreign('Usuario_id')->references('id')->on('Users');
            $table->string('Nota')->nullable();
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
        Schema::dropIfExists('autorizacions');
    }
}
