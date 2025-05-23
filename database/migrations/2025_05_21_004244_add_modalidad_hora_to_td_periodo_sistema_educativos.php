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
        Schema::table('td_periodo_sistema_educativos', function (Blueprint $table) {
            $table->bigInteger('modalidad_id')->after('nota')->nullable()->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('tm_generalidades');
            $table->time('hora_ini')->after('modalidad_id')->nullable();
            $table->time('hora_fin')->after('hora_ini')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('td_periodo_sistema_educativos', function (Blueprint $table) {
            $table->dropColumn('modalidad_id');
            $table->dropColumn('hora_ini');
            $table->dropColumn('hora_fin');
        });
    }
};
