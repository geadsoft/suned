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
        Schema::create('tr_deudas_cabs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('tm_personas');
            $table->bigInteger('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');
            $table->string('referencia',30);
            $table->datetime('fecha');
            $table->double('basedifgravada',14,6);
            $table->double('basegravada',14,6);
            $table->double('impuesto',14,6);
            $table->double('descuento',14,6);
            $table->double('neto',14,6);
            $table->double('debito',14,6);
            $table->double('credito',14,6);
            $table->double('saldo',14,6);
            $table->string('glosa',80);
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
        Schema::dropIfExists('tr_deudas_cabs');
    }
};
