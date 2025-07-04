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
        Schema::table('tm_files', function (Blueprint $table) {
            $table->boolean('actividad')->after('entrega')->default(false);
            $table->boolean('tarea')->after('actividad')->default(false);
            $table->boolean('recurso')->after('tarea')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_files', function (Blueprint $table) {
            $table->dropColumn('actividad');
            $table->dropColumn('tarea');
            $table->dropColumn('recurso');
        });
    }
};
