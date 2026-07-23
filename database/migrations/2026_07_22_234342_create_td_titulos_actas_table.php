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
        Schema::create('td_titulos_actas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_id')
            ->constrained('tm_matriculas');

            $table->boolean('acta_retirada')->default(false);
            $table->boolean('titulo_retirado')->default(false);

            $table->dateTime('fecha_acta')->nullable();
            $table->string('entregado_acta_por')->nullable();
            $table->string('recibido_acta_por')->nullable();

            $table->dateTime('fecha_titulo')->nullable();
            $table->string('entregado_titulo_por')->nullable();
            $table->string('recibido_titulo_por')->nullable();
            
            $table->text('comentario')->nullable();
            $table->string('archivo')->nullable();
            $table->string('drive_id')->nullable();

            $table->string('usuario');
            $table->timestamps();

            $table->unique('matricula_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_titulos_actas');
    }
};
