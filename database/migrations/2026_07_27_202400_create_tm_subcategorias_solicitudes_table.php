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
        Schema::create('tm_subcategoria_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('categoria',15)->nullable();
            $table->string('subcategoria',80)->nullable();
            $table->string('tiempo_entrega',80)->nullable();
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
        Schema::dropIfExists('tm_subcategoria_solicitudes');
    }
};
