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
        Schema::create('td_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('solicitud_id')->unsigned();
            $table->bigInteger('subcategoria_id')->unsigned();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('curso_id')->unsigned();
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('solicitud_id')->references('id')->on('tc_solicitudes');
            $table->foreign('subcategoria_id')->references('id')->on('tm_subcategoria_solicitudes');
            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('curso_id')->references('id')->on('tm_servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_solicitudes');
    }
};
