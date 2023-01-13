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
        Schema::create('tm_pensiones_dets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pension_id')->unsigned();
            $table->foreign('pension_id')->references('id')->on('tm_pensiones_cabs');
            $table->bigInteger('nivel_id')->unsigned();
            $table->foreign('nivel_id')->references('id')->on('tm_generalidades');
            $table->double('matricula',14,6);
            $table->double('matricula2',14,6);
            $table->double('pension',14,6);
            $table->double('eplataforma',14,6);
            $table->double('iplataforma',14,6);
            $table->string('estado',1);
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
        Schema::dropIfExists('tm_pensiones_dets');
    }
};
