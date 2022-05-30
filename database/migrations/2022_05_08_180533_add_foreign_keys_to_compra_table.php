<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compra', function (Blueprint $table) {
            $table->foreign(['idpersona'], 'fk_compra_persona1')->references(['idpersona'])->on('persona')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['idproveedor'], 'fk_compra_proveedor1')->references(['idproveedor'])->on('proveedor')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compra', function (Blueprint $table) {
            $table->dropForeign('fk_compra_persona1');
            $table->dropForeign('fk_compra_proveedor1');
        });
    }
}
