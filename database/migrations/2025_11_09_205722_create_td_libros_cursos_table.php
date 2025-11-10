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
        Schema::create('td_libros_cursos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('libro_id')->unsigned();
            $table->bigInteger('curso_id')->unsigned();
            $table->string('usuario');
            $table->timestamps();

            $table->foreign('libro_id')->references('id')->on('tm_libros');
            $table->foreign('curso_id')->references('id')->on('tm_servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('td_libros_cursos');
    }
};
