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
        Schema::table('tm_reportes', function (Blueprint $table) {
            $table->boolean('graduado')->after('curso_promovido')->default(false); // nuevo campo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_reportes', function (Blueprint $table) {
            $table->dropColumn('graduado');
        });
    }
};
