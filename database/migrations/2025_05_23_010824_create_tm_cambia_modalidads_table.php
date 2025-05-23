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
        Schema::create('tm_cambia_modalidad', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('persona_id')->unsigned();
            $table->bigInteger('matricula_id')->unsigned();
            $table->bigInteger('modalidad_id')->unsigned();
            $table->bigInteger('grado_id')->unsigned();
            $table->bigInteger('curso_id')->unsigned();
            $table->string('modalidad',30);
            $table->string('curso',50);
            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('tm_personas');
            $table->foreign('matricula_id')->references('id')->on('tm_matriculas');
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->foreign('grado_id')->references('id')->on('tm_servicios');
            $table->foreign('curso_id')->references('id')->on('tm_cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_cambia_modalidad');
    }
};
