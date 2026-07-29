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
        Schema::table('tm_periodos_lectivos', function (Blueprint $table) {
            $table->Integer('num_solicitud')->after('num_matricula')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_periodos_lectivos', function (Blueprint $table) {
            $table->dropColumn('num_solicitud');
        });
    }
};
