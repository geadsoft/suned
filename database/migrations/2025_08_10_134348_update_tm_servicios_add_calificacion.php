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
        Schema::table('tm_servicios', function (Blueprint $table) {
            
            $table->string('calificacion',1)->after('especializacion_id'); // nuevo campo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_servicios', function (Blueprint $table) {
        $table->dropColumn('calificacion');
        });
    
    }
};
