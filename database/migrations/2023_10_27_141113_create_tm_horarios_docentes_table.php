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
        Schema::create('tm_horarios_docentes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('horario_id')->unsigned();
            $table->foreign('horario_id')->references('id')->on('tm_horarios');
            $table->bigInteger('asignatura_id')->unsigned();
            $table->foreign('asignatura_id')->references('id')->on('tm_asignaturas');
            $table->bigInteger('docente_id')->unsigned()->nullable();
            $table->foreign('docente_id')->references('id')->on('tm_personas');
            $table->string('usuario');
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
        Schema::dropIfExists('tm_horarios_docentes');
    }
};
