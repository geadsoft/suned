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
            $table->string('docaplica',15)->after('neto')->default('');
            $table->datetime('fecha_docaplica')->after('docaplica')->nullable();
            $table->string('motivo')->after('fecha_docaplica')->default('');
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
            $table->dropColumn('docaplica');
            $table->dropColumn('fecha_docaplica');
            $table->dropColumn('motivo');
        });
    }
};
