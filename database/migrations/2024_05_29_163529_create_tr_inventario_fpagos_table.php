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
        Schema::create('tr_inventario_fpagos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventariocab_id')->unsigned();
            $table->foreign('inventariocab_id')->references('id')->on('tr_inventario_cabs');
            $table->integer('linea');
            $table->string('tipopago',3);
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
        Schema::dropIfExists('tr_inventario_fpagos');
    }
};
