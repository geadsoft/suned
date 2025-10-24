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
        Schema::create('tm_ppe_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('modalidad_id')->unsigned();
            $table->bigInteger('grado_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->foreign('persona_id')->references('id')->on('tm_personas');
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
        Schema::dropIfExists('tm_ppe_estudiantes');
    }
};
