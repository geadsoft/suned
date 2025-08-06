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
        Schema::table('td_asistencia_diarias', function (Blueprint $table) {
            //$table->dropColumn('falta'); // eliminar el campo anterior
            $table->string('valor', 2)->after('fecha'); // nuevo campo

            $table->bigInteger('periodo_id')->unsigned()->after('docente_id');
            $table->tinyInteger('mes')->after('periodo_id');

            $table->foreign('periodo_id')->references('id')->on('tm_periodos_lectivos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('td_asistencia_diarias', function (Blueprint $table) {
        //$table->boolean('falta')->after('fecha');
        $table->dropColumn('valor');
        $table->dropColumn('periodo_id');
        $table->dropColumn('mes');
        });
    }
};
