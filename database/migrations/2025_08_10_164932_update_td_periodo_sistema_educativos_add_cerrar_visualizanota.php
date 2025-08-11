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
        
            $table->boolean('cerrar')->after('glosa')->default(false); // nuevo campo
            $table->boolean('visualizar_nota')->after('cerrar')->default(false); // nuevo campo
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
        $table->dropColumn('cerrar');
        $table->dropColumn('visualizar_nota');
        });
    }
};
