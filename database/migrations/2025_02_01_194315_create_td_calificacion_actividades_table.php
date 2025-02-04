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
        Schema::create('td_calificacion_actividades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('actividad_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->double('nota',14,2);
            $table->string('estado',1);
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('tm_actividades');
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
        Schema::dropIfExists('td_calificacion_actividades');
    }
};
