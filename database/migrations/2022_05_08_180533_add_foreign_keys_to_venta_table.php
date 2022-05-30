<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venta', function (Blueprint $table) {
            $table->foreign(['idusuario'], 'fk_venta_persona1')->references(['idpersona'])->on('persona')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venta', function (Blueprint $table) {
            $table->dropForeign('fk_venta_persona1');
        });
    }
}
