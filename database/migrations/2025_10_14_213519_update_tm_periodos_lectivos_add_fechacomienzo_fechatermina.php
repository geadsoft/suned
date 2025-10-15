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
        
            $table->datetime('fecha_empieza')->after('folio')->nullable(); // nuevo campo
            $table->datetime('fecha_termina')->after('fecha_empieza')->nullable(); // nuevo campo

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
        $table->dropColumn('fecha_empieza');
        $table->dropColumn('fecha_termina');
        });
    }
};
