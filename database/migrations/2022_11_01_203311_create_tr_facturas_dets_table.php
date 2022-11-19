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
        Schema::create('tr_facturas_dets', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo');
            $table->integer('mes');
            $table->bigInteger('facturacab_id')->unsigned();
            $table->foreign('facturacab_id')->references('id')->on('tr_facturas_cabs');
            $table->integer('linea');
            $table->string('cobro_id',15);
            $table->string('descripcion',100);
            $table->string('unidad',3);
            $table->double('cantidad',14,2);
            $table->double('precio',14,6);
            $table->double('descuento',14,6);
            $table->double('impuesto',14,6);
            $table->double('total',14,6);
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
        Schema::dropIfExists('tr_facturas_dets');
    }
};
