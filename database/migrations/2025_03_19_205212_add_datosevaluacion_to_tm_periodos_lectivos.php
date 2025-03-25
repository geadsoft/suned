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
            $table->string('evaluacion',3)->after('estado');
            $table->double('evaluacion_formativa',14,2)->after('evaluacion');
            $table->double('evaluacion_sumativa',14,2)->after('evaluacion_formativa');
            $table->boolean('aperturado')->after('evaluacion_sumativa')->default(false);
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
            $table->dropColumn('evaluacion');
            $table->dropColumn('evaluacion_formativa');
            $table->dropColumn('evaluacion_sumativa');
            $table->dropColumn('aperturado');
        });
    }
};
