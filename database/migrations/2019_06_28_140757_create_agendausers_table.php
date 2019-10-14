<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendausersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendausers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Medico_id')->nullable()->unsigned()->index();
            $table->foreign('Medico_id')->references('id')->on('Users');
            $table->bigInteger('Agenda_id')->nullable()->unsigned()->index();
            $table->foreign('Agenda_id')->references('id')->on('Agendas');
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
        Schema::dropIfExists('agendausers');
    }
}
