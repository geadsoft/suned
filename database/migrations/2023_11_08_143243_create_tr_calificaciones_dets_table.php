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
        Schema::create('tr_calificaciones_dets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('calificacioncab_id')->unsigned();
            $table->foreign('calificacioncab_id')->references('id')->on('tr_calificaciones_cabs');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('tm_personas');
            $table->datetime('fecha');
            $table->double('calificacion',14,2)->nullable();
            $table->string('escala_cualitativa',5);
            $table->string('observacion',200);
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
        Schema::dropIfExists('tr_calificaciones_dets');
    }
};
