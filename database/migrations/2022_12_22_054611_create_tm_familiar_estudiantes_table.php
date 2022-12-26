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
        Schema::create('tm_familiar_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('tm_personas');
            $table->bigInteger('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('tm_personas');
            $table->string('informacion',2);
            $table->string('usuario',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_familiar_estudiantes');
    }
};
