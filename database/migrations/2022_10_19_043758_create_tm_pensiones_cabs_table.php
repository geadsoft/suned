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
        Schema::create('tm_pensiones_cabs', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',80);
            $table->datetime('fecha');
            $table->bigInteger('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->bigInteger('modalidad_id')->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->string('estado',1);
            $table->string('usuario');
            $table->unique(['periodo_id', 'modalidad_id'],'periodo_modalidad_unique');
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
        Schema::dropIfExists('tm_pensiones_cabs');
    }
};
