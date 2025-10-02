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
        Schema::create('td_boletin_finals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('modalidad_id')->unsigned();
             $table->bigInteger('curso_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->bigInteger('asignatura_id')->unsigned();
            $table->double('1T_notaparcial',14,2)->default(0);
            $table->double('1T_nota70',14,2)->default(0);
            $table->double('1T_evaluacion',14,2)->default(0);
            $table->double('1T_nota30',14,2)->default(0);
            $table->double('1T_notatrimestre',14,2)->default(0);
            $table->double('2T_notaparcial',14,2)->default(0);
            $table->double('2T_nota70',14,2)->default(0);
            $table->double('2T_evaluacion',14,2)->default(0);
            $table->double('2T_nota30',14,2)->default(0);
            $table->double('2T_notatrimestre',14,2)->default(0);
            $table->double('3T_notaparcial',14,2)->default(0);
            $table->double('3T_nota70',14,2)->default(0);
            $table->double('3T_evaluacion',14,2)->default(0);
            $table->double('3T_nota30',14,2)->default(0);
            $table->double('3T_notatrimestre',14,2)->default(0);
            $table->double('promedio_anual',14,2)->default(0);
            $table->double('supletorio',14,2)->default(0);
            $table->double('promedio_final',14,2)->default(0);
            $table->string('promedio_cualitativo')->nullable()->default('');
            $table->string('promocion')->nullable()->default('');
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->foreign('curso_id')->references('id')->on('tm_cursos');
            $table->foreign('persona_id')->references('id')->on('tm_personas');
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
        Schema::dropIfExists('td_boletin_finals');
    }
};
