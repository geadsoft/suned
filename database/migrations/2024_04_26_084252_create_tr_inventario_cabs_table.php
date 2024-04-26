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
        Schema::create('tr_inventario_cabs', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo');
            $table->integer('mes');
            $table->string('tipo',3);
            $table->string('documento',7);
            $table->datetime('fecha');
            $table->string('movimiento',2);
            $table->string('referencia',50)->nullable();
            $table->integer('estudiante_id')->nullable();
            $table->string('tipopago',3);
            $table->string('observacion',80)->nullable();
            $table->double('neto',14,6);
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
        Schema::dropIfExists('tr_inventario_cabs');
    }
};
