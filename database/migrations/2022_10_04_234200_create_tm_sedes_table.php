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
        Schema::create('tm_sedes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',8);
            $table->string('nombre',150);
            $table->string('denominacion',3);
            $table->integer('inicia_actividad');
            $table->string('telefono_sede',15);
            $table->string('email_sede',50);
            $table->string('website',50);
            $table->string('representante',80);
            $table->string('identificacion',13);
            $table->boolean('fin_semana')->default(false);
            $table->boolean('jornada_completa')->default(false);
            $table->boolean('matutino')->default(false);
            $table->boolean('vespertino')->default(false);
            $table->boolean('nocturno')->default(false);
            $table->bigInteger('provincia_id')->unsigned();
            $table->foreign('provincia_id')->references('id')->on('tm_zonas');
            $table->bigInteger('canton_id')->unsigned();
            $table->foreign('canton_id')->references('id')->on('tm_zonas');
            $table->bigInteger('parroquia_id')->unsigned();
            $table->foreign('parroquia_id')->references('id')->on('tm_zonas');
            $table->string('direccion_sede',50);
            $table->string('logo_sede')->nullable();
            $table->string('ruc',13);
            $table->string('razon_social',150);
            $table->string('nombre_comercial',150);
            $table->string('telefono',15);
            $table->string('email',50);
            $table->string('direccion',50);
            $table->boolean('lleva_contabilidad')->default(false);
            $table->boolean('regimen_rimpe')->default(false);
            $table->boolean('contribuyente_especial')->default(false);
            $table->string('resolucion_ce',15)->nullable();
            $table->boolean('agente_retencion')->default(false);
            $table->string('resolucion_ar',15)->nullable();
            $table->string('establecimiento',3);
            $table->string('nombre_establecimiento',150);
            $table->string('direccion_establecimiento',150);
            $table->string('punto_emision',3);
            $table->integer('secuencia_factura');
            $table->integer('secuencia_ncredito');
            $table->string('archivo_firma')->nullable();
            $table->string('clave_firma',30)->nullable();
            $table->string('usuario');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_sedes');
    }
};
