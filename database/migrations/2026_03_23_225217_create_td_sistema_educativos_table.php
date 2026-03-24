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
        Schema::create('tm_sistema_educativos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periodo_id')->unsigned();
            $table->bigInteger('modalidad_id')->unsigned();
            $table->string('evaluacion',3)->default('T');;
            $table->double('evaluacion_formativa',14,2)->default(0);
            $table->double('evaluacion_sumativa',14,2)->default(0);            
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_sistema_educativos');
    }
};
