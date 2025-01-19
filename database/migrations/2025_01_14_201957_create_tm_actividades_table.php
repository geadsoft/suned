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
        Schema::create('tm_actividades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('docente_id')->unsigned();
            $table->bigInteger('paralelo')->unsigned();
            $table->string('termino',3);
            $table->string('bloque',3);
            $table->string('tipo',2);
            $table->string('actividad',3);
            $table->string('nombre',80);
            $table->string('descripcion');
            $table->datetime('fecha');
            $table->string('subir_archivo',2);
            $table->double('puntaje',14,2);
            $table->string('enlace',80);
            $table->string('estado',1);
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('paralelo')->references('id')->on('tm_horarios_docentes');
            $table->foreign('docente_id')->references('id')->on('tm_personas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_actividades');
    }
};
