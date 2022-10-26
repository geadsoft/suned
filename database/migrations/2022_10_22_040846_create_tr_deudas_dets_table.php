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
        Schema::create('tr_deudas_dets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deudacab_id')->unsigned();
            $table->foreign('deudacab_id')->references('id')->on('tr_deudas_cabs');
            $table->Integer('cobro_id');
            $table->datetime('fecha');
            $table->string('detalle',100);
            $table->string('tipo',5);
            $table->string('referencia',10);
            $table->string('tipovalor',2);
            $table->double('valor',14,6);
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
        Schema::dropIfExists('tr_deudas_dets');
    }
};

