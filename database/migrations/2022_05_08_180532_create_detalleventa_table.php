<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleventa', function (Blueprint $table) {
            $table->unsignedInteger('iddetalleventa');
            $table->unsignedInteger('idventa')->index('fk_detalleventa_venta1_idx');
            $table->unsignedInteger('idproducto')->index('fk_detalleventa_producto1_idx');
            $table->integer('cantidad')->nullable();
            $table->decimal('precioventa', 10)->nullable();
            $table->decimal('subtotal', 10)->nullable();
            $table->dateTime('fecharegistro')->nullable();

            $table->primary(['iddetalleventa', 'idventa', 'idproducto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleventa');
    }
}
