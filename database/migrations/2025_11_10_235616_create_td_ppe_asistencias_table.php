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
        Schema::create('td_ppe_asistencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('docente_id')->unsigned();
            $table->string('fase',2);
            $table->bigInteger('curso_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->datetime('fecha');
            $table->string('valor',3);
            $table->string('usuario');
            $table->timestamps();
            
            $table->foreign('docente_id')->references('id')->on('tm_personas');
            $table->foreign('persona_id')->references('id')->on('tm_personas');
            $table->foreign('curso_id')->references('id')->on('tm_servicios');
            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_ppe_asistencias');
    }
};
