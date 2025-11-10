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
        Schema::create('tm_libros', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('docente_id')->unsigned();
            $table->string('nombre',150);
            $table->string('autor',150);
            $table->bigInteger('asignatura_id')->unsigned();
            $table->string('drive_id',50);
            $table->string('portada',150);
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
        Schema::dropIfExists('tm_libros');
    }
};
