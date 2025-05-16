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
        Schema::table('tm_actividades', function (Blueprint $table) {
            $table->datetime('fecha_entrega')->after('enlace')->nullable();
            $table->string('comentario',250)->after('fecha_entrega')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_actividades', function (Blueprint $table) {
            $table->dropColumn('fecha_entrega');
            $table->dropColumn('comentario');
        });
    }
};
