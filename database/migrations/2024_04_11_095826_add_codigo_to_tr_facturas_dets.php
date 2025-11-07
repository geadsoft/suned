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
        Schema::table('tr_facturas_dets', function (Blueprint $table) {
            $table->string('codigo',20)->after('deudadet_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_facturas_dets', function (Blueprint $table) {
            $table->dropColumn('codigo');
        });
    }
};
