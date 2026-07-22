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
        Schema::create('td_expediente_matriculas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('expediente_matricula_id')
                ->constrained('tm_expediente_matriculas')
                ->cascadeOnDelete();

            $table->foreignId('expediente_id')
                ->constrained('tm_expedientes');

            $table->string('nombre', 200)->nullable();

            $table->string('extension', 10)->nullable();

            $table->string('observacion', 150)->nullable();

            $table->boolean('documentacion_retirada')->default(false);
            
            $table->string('drive_id', 100)->nullable();

            $table->string('usuario')->nullable();

            $table->timestamps();

            // Evita registrar el mismo documento dos veces
            $table->unique(
                ['expediente_matricula_id', 'expediente_id'],
                'uk_expediente_documento'
            );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_expediente_matriculas');
    }
};
