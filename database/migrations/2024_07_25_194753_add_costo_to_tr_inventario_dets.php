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
        Schema::table('tr_inventario_dets', function (Blueprint $table) {
            $table->double('costo',14,2)->after('cantidad')->default(0);
            $table->double('costo_total')->after('costo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_inventario_dets', function (Blueprint $table) {
            $table->dropColumn('costo');
            $table->dropColumn('costo_total');
        });
    }
};
