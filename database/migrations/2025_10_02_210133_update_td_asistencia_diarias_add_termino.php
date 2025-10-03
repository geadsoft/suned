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
        
            $table->string('termino',3)->after('periodo_id'); // nuevo campo

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
        $table->dropColumn('termino');
        });
    }
};
