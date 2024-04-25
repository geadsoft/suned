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
        Schema::create('tm_productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',20);
            $table->string('nombre',50);
            $table->string('descripcion',80);
            $table->string('unidad',3);
            $table->integer('talla');
            $table->bigInteger('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('tm_generalidades');
            $table->string('tipo',1);
            $table->integer('tipo_iva');
            $table->boolean('maneja_stock');
            $table->double('stock',14,6)->default(0);
            $table->double('stock_min',14,6);
            $table->double('precio',14,6)->default(0.00);
            $table->string('foto',30);
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
        Schema::dropIfExists('tm_productos');
    }
};
