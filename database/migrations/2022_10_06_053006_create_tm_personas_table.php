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
        Schema::create('tm_personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres',150);
            $table->string('apellidos',150);
            $table->string('tipoidentificacion',1);
            $table->string('identificacion',15);
            $table->datetime('fechanacimiento');
            $table->integer('nacionalidad');
            $table->string('genero',1);
            $table->string('telefono',30);
            $table->string('direccion',150);
            $table->string('email',80);
            $table->string('etnia',2);
            $table->string('parentesco',2);
            $table->string('tipopersona',1);
            $table->integer('relacion_id');
            $table->string('estado',1);
            $table->string('usuario',50);
            $table->unique(['identificacion'],'uq_identificacion');
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
        Schema::dropIfExists('tm_personas');
    }
};
