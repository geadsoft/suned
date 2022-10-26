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
        Schema::create('tm_matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('documento',10);
            $table->datetime('fecha');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('tm_personas');
            $table->bigInteger('nivel_id')->unsigned();
            $table->foreign('nivel_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('modalidad_id')->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->bigInteger('seccion_id')->unsigned();
            $table->foreign('seccion_id')->references('id')->on('tm_cursos');
            $table->string('estado',1);
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
        Schema::dropIfExists('tm_matriculas');
    }
};
