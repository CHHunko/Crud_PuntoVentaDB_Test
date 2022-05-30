<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallecompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecompra', function (Blueprint $table) {
            $table->unsignedInteger('iddetallecompra');
            $table->unsignedInteger('idcompra')->index('fk_detallecompra_compra1_idx');
            $table->unsignedInteger('idproducto')->index('fk_detallecompra_producto1_idx');
            $table->integer('cantidad')->nullable();
            $table->decimal('preciocompra', 10)->nullable();
            $table->decimal('precioventa', 10)->nullable();
            $table->decimal('total', 10)->nullable();
            $table->dateTime('fecharegistro')->nullable();

            $table->primary(['iddetallecompra', 'idcompra', 'idproducto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detallecompra');
    }
}
