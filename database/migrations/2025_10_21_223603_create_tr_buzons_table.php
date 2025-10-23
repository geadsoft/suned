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
        Schema::create('tr_buzons', function (Blueprint $table) {
            $table->id();
            $table->string('categoria',1);
            $table->string('tipo',1);
            $table->string('identificacion',13);
            $table->string('nombres',100);
            $table->string('email',40);
            $table->string('telefono',30);
            $table->text('comentario');
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
        Schema::dropIfExists('tr_buzons');
    }
};
