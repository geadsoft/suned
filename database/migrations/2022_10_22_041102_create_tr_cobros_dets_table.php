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
        Schema::create('tr_cobros_dets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cobrocab_id')->unsigned();
            $table->foreign('cobrocab_id')->references('id')->on('tr_cobros_cabs');
            $table->string('tipopago',3);
            $table->bigInteger('entidad_id')->unsigned();
            $table->foreign('entidad_id')->references('id')->on('tm_generalidades');
            $table->string('referencia',100);
            $table->string('numero',15);
            $table->string('cuenta',15);
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
        Schema::dropIfExists('tr_cobros_dets');
    }
};
