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
        Schema::create('tm_calendario_grados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('calendario_id')->unsigned();
            $table->foreign('calendario_id')->references('id')->on('tm_calendario_eventos');
            $table->bigInteger('modalidad_id')->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('tm_servicios');
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
        Schema::dropIfExists('tm_calendario_grados');
    }
};
