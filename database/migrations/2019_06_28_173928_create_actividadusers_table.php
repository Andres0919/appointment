<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividadusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('User_id')->nullable()->unsigned()->index();
            $table->foreign('User_id')->references('id')->on('Users');
            $table->bigInteger('Actividadcargo_id')->nullable()->unsigned()->index();
            $table->foreign('Actividadcargo_id')->references('id')->on('Actividadcargos');
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
        Schema::dropIfExists('actividadusers');
    }
}
