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
        Schema::table('tr_cobros_cabs', function (Blueprint $table) {
            $table->datetime('fechapago')->after('documento')->nullable();
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_cobros_cabs', function (Blueprint $table) {
            $table->dropColumn('fechapago');
        });
    }
};
