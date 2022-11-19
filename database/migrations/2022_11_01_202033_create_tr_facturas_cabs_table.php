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
        Schema::create('tr_facturas_cabs', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo');
            $table->integer('mes');
            $table->string('tipo',2);
            $table->datetime('fecha');
            $table->string('establecimiento',3);
            $table->string('puntoemision',3);
            $table->string('documento',9);
            $table->bigInteger('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('tm_personas');
            $table->double('subtotal_grabado',14,6);
            $table->double('subtotal_nograbado',14,6);
            $table->double('subtotal_nosujeto',14,6);
            $table->double('subtotal_excento',14,6);
            $table->double('descuento',14,6);
            $table->double('subtotal',14,6);
            $table->double('impuesto',14,6);
            $table->double('neto',14,6);
            $table->string('estado',1);
            $table->string('docelectronico_id')->nullable();
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
        Schema::dropIfExists('tr_facturas_cabs');
    }
};
