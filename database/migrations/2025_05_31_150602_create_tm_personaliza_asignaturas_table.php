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
        Schema::create('tm_personaliza_asignaturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('asignatura_id')->unsigned();
            $table->text('nombre',100);
            $table->text('imagen');
            $table->string('abreviatura',10);
            $table->timestamps();

            $table->foreign('asignatura_id')->references('id')->on('tm_asignaturas');
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
        Schema::dropIfExists('tm_personaliza_asignaturas');
    }
};
