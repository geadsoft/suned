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
        Schema::create('tc_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('documento', 7)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('solicitante',100)->nullable();
            $table->string('nui',20)->nullable();
            $table->bigInteger('persona_id')->unsigned();
            $table->dateTime('fecha_entrega')->nullable();
            $table->bigInteger('servidor')->nullable();
            $table->string('forma_solicitud', 1)->nullable();
            $table->string('celular', 10)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('observacion', 150)->nullable();
            $table->string('estado', 1)->nullable();
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('tm_personas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tc_solicitudes');
    }
};
