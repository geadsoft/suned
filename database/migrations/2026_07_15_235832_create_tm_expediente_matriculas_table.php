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
        Schema::create('tm_expediente_matriculas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('matricula_id')
                ->constrained('tm_matriculas');

            $table->boolean('documentacion_completa')->default(false);

            $table->string('comentario_impresion', 200)->nullable();
            $table->string('comentario_secretaria', 200)->nullable();
            $table->boolean('documentacion_retirada')->default(false);
            $table->string('comentario_retiro', 200)->nullable();

            $table->string('estado', 1)->default('A');
            $table->string('usuario')->nullable();

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
        Schema::dropIfExists('tm_expediente_matriculas');
    }
};
