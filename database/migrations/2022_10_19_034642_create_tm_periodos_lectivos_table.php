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
        Schema::create('tm_periodos_lectivos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',80);
            $table->bigInteger('sede_id')->unsigned();
            $table->foreign('sede_id')->references('id')->on('tm_empresas');
            $table->integer('periodo');
            $table->bigInteger('rector_id')->unsigned();
            $table->foreign('rector_id')->references('id')->on('tm_personas');
            $table->bigInteger('secretaria_id')->unsigned();
            $table->foreign('secretaria_id')->references('id')->on('tm_personas');
            $table->bigInteger('coordinador_id')->unsigned();
            $table->foreign('coordinador_id')->references('id')->on('tm_personas');
            $table->integer('num_recibo');
            $table->integer('num_matricula');
            $table->integer('mes_pension');
            $table->integer('folio');
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
        Schema::dropIfExists('tm_periodos_lectivos');
    }
};
