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
        Schema::table('tm_pase_cursos', function (Blueprint $table) {
            $table->bigInteger('curso_anterior')->after('modalidad_id')->nullable()->unsigned();
            $table->foreign('curso_anterior')->references('id')->on('tm_pase_cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_pase_cursos', function (Blueprint $table) {
            $table->dropColumn('curso_anterior');
        });
    }
};
