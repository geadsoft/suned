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
            $table->integer('periodo_id')->after('persona_id')->nullable();
            $table->integer('estudiante_id')->after('periodo_id')->nullable();
            $table->integer('formapago')->after('estudiante_id')->default(20);
            $table->integer('dias')->after('formapago')->default(0);
            $table->string('plazo',6)->after('dias')->nullable();
            $table->string('autorizacion',49)->after('documento')->nullable();
            $table->datetime('fecha_autorizacion')->after('documento')->nullable();
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
            $table->dropColumn('periodo_id');
            $table->dropColumn('estudiante_id');
            $table->dropColumn('formapago');
            $table->dropColumn('dias');
            $table->dropColumn('plazo');
            $table->dropColumn('autorizacion');
            $table->dropColumn('fecha_autorizacion');
        });
    }
};
