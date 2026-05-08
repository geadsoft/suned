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
        Schema::table('tr_facturas_cabs', function (Blueprint $table) {
            $table->bigInteger('matricula_id')->after('periodo_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_facturas_cabs', function (Blueprint $table) {
             $table->dropColumn('matricula_id');
        });
    }
};
