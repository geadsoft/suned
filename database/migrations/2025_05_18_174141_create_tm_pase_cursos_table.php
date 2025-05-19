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
        Schema::create('tm_pase_cursos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('matricula_id')->unsigned();
            $table->foreign('matricula_id')->references('id')->on('tm_matriculas');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('tm_personas');
            $table->bigInteger('modalidad_id')->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('nivel_id')->unsigned();
            $table->foreign('nivel_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('tm_servicios');
            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('tm_cursos');
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
        Schema::dropIfExists('tm_pase_cursos');
    }
};
