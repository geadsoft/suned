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
        Schema::create('tr_cobros_cabs', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('tm_personas');
            $table->bigInteger('matricula_id')->unsigned();
            $table->foreign('matricula_id')->references('id')->on('tm_matriculas');
            $table->string('tipo',2)->default('CP');
            $table->string('documento',10)->nullable();
            $table->string('concepto',100);
            $table->double('monto',14,6);
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
        Schema::dropIfExists('tr_cobros_cabs');
    }
};
