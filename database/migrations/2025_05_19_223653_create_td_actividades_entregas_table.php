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
        Schema::create('td_actividades_entregas', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->bigInteger('actividad_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->text('comentario');
            $table->double('nota',14,2);
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
        Schema::dropIfExists('td_actividades_entregas');
    }
};
