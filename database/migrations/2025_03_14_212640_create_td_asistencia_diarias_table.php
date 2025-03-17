<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('td_asistencia_diarias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('docente_id')->unsigned();
            $table->bigInteger('asignatura_id')->unsigned();
            $table->bigInteger('curso_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->datetime('fecha');
            $table->boolean('falta');
            $table->string('usuario');
            $table->timestamps();
            
            $table->foreign('docente_id')->references('id')->on('tm_personas');
            $table->foreign('asignatura_id')->references('id')->on('tm_generalidades');
            $table->foreign('persona_id')->references('id')->on('tm_personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_asistencia_diarias');
    }
};
