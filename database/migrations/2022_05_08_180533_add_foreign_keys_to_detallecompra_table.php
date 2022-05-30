<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetallecompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detallecompra', function (Blueprint $table) {
            $table->foreign(['idcompra'], 'fk_detallecompra_compra1')->references(['idcompra'])->on('compra')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['idproducto'], 'fk_detallecompra_producto1')->references(['idproducto'])->on('producto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detallecompra', function (Blueprint $table) {
            $table->dropForeign('fk_detallecompra_compra1');
            $table->dropForeign('fk_detallecompra_producto1');
        });
    }
}
