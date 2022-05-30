<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->unsignedInteger('idventa');
            $table->string('tipodocumento', 45)->nullable();
            $table->string('numerodocumento', 45)->nullable();
            $table->unsignedInteger('idusuario')->index('fk_venta_persona1_idx');
            $table->string('documentocliente', 45)->nullable();
            $table->string('nombrecliente', 45)->nullable();
            $table->decimal('totalpagar', 10)->nullable();
            $table->decimal('pagocon', 10)->nullable();
            $table->decimal('cambio', 10)->nullable();
            $table->dateTime('fecharegistro')->nullable();

            $table->primary(['idventa', 'idusuario']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta');
    }
}
