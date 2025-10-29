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
        Schema::create('tm_ppe_actividades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('docente_id')->unsigned();
            $table->bigInteger('modalidad_id')->unsigned();
            $table->bigInteger('grado_id')->unsigned();
            $table->string('tipo',2);
            $table->string('actividad',3);
            $table->text('nombre');
            $table->longtext('descripcion');
            $table->datetime('fecha_entrega');
            $table->string('subir_archivo',2);
            $table->double('puntaje',14,2);
            $table->string('enlace',300);
            $table->string('estado',1);
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('docente_id')->references('id')->on('tm_personas');
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->foreign('grado_id')->references('id')->on('tm_servicios');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_ppe_actividades');
    }
};
