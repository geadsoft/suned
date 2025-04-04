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
        Schema::create('tm_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('actividad_id')->unsigned();
            $table->bigInteger('persona_id')->unsigned();
            $table->string('nombre');
            $table->string('drive_id',80);
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
        Schema::dropIfExists('tm_files');
    }
};
