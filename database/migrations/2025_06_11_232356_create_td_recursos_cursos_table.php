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
        Schema::create('td_recursos_cursos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('recurso_id')->unsigned();
            $table->bigInteger('curso_id')->unsigned();
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('recurso_id')->references('id')->on('tm_recursos');
            $table->foreign('curso_id')->references('id')->on('tm_cursos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_recursos_cursos');
    }
};
