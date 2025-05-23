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
        Schema::table('tm_horarios_asignaturas', function (Blueprint $table) {
            $table->bigInteger('hora_id')->after('asignatura_id')->nullable()->unsigned();
            $table->foreign('hora_id')->references('id')->on('td_periodo_sistema_educativos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_horarios_asignaturas', function (Blueprint $table) {
            $table->dropColumn('hora_id');
        });
    }
};
