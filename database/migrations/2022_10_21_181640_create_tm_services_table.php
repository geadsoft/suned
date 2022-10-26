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
        Schema::create('tm_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',80);
            $table->bigInteger('modalidad_id')->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('nivel_id')->unsigned();
            $table->foreign('nivel_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('especializacion_id')->unsigned();
            $table->foreign('especializacion_id')->references('id')->on('tm_generalidades');
            $table->string('estado',1);
            $table->string('usuario');
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
        Schema::dropIfExists('tm_servicios');
    }
};
