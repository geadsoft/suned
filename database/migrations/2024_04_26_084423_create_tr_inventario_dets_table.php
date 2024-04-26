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
        Schema::create('tr_inventario_dets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventariocab_id')->unsigned();
            $table->foreign('inventariocab_id')->references('id')->on('tr_inventario_cabs');
            $table->integer('periodo');
            $table->integer('mes');
            $table->string('tipo',3);
            $table->string('documento',7);
            $table->datetime('fecha');
            $table->string('movimiento',2);
            $table->integer('linea');
            $table->bigInteger('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('tm_productos');
            $table->string('unidad',3);
            $table->double('cantidad',14,2);
            $table->double('precio',14,2);
            $table->double('total',14,2);
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
        Schema::dropIfExists('tr_inventario_dets');
    }
};
