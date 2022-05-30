<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetalleventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalleventa', function (Blueprint $table) {
            $table->foreign(['idproducto'], 'fk_detalleventa_producto1')->references(['idproducto'])->on('producto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['idventa'], 'fk_detalleventa_venta1')->references(['idventa'])->on('venta')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalleventa', function (Blueprint $table) {
            $table->dropForeign('fk_detalleventa_producto1');
            $table->dropForeign('fk_detalleventa_venta1');
        });
    }
}
