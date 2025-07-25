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
        Schema::create('tm_recursos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('docente_id')->unsigned();
            $table->bigInteger('asignatura_id')->unsigned();
            $table->string('nombre',100);
            $table->string('enlace',300);
            $table->string('estado',1);
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('docente_id')->references('id')->on('tm_personas');
            $table->foreign('asignatura_id')->references('id')->on('tm_asignaturas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_recursos');
    }
};
