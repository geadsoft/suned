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
        Schema::table('tm_sedes', function (Blueprint $table) {
            $table->integer('ambiente')->after('clave_firma')->nullable();
            $table->string('docgenerado')->after('ambiente')->nullable();
            $table->string('docautorizado')->after('docgenerado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_sedes', function (Blueprint $table) {
            $table->dropColumn('ambiente');
            $table->dropColumn('docgenerado');
            $table->dropColumn('docautorizado');
        });
    }
};
