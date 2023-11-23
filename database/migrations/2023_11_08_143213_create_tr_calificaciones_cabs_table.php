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
        Schema::create('tr_calificaciones_cabs', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->bigInteger('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('servicio_id')->unsigned();
            $table->foreign('servicio_id')->references('id')->on('tm_servicios');
            $table->bigInteger('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('tm_cursos');
            $table->bigInteger('asignatura_id')->unsigned();
            $table->foreign('asignatura_id')->references('id')->on('tm_asignaturas');
            $table->string('ciclo_academico',1);
            $table->string('evaluacion',1);
            $table->string('parcial',2);
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
        Schema::dropIfExists('tr_calificaciones_cabs');
    }
};
