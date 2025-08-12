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
        Schema::create('td_conductas', function (Blueprint $table) {
            
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('modalidad_id')->unsigned();
            $table->string('termino',3);
            $table->bigInteger('curso_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->string('evaluacion',1);
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->foreign('curso_id')->references('id')->on('tm_cursos');
            $table->foreign('persona_id')->references('id')->on('tm_personas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_conductas');
    }
};
