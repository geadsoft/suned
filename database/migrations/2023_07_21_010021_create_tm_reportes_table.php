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
        Schema::create('tm_reportes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo',3);
            $table->datetime('emision');
            $table->string('periodo',15);
            $table->string('identificacion',13);
            $table->string('nombres',150);
            $table->string('curso',200);
            $table->string('especializacion',60);
            $table->integer('folio');
            $table->integer('matricula');
            $table->datetime('fecha');
            $table->double('nota',12,2);
            $table->string('escala',3);
            $table->string('asunto',50);
            $table->string('destinatario',100);
            $table->string('institucion',100);
            $table->string('cargo',40);
            $table->string('rector',50);
            $table->string('secretaria',50);
            $table->string('coordinador',50);
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
        Schema::dropIfExists('tm_reportes');
    }
};
