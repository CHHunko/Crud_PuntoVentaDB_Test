<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->unsignedInteger('idcompra');
            $table->unsignedInteger('idpersona')->index('fk_compra_persona1_idx');
            $table->unsignedInteger('idproveedor')->index('fk_compra_proveedor1_idx');
            $table->decimal('montototal', 10)->nullable();
            $table->string('tipodocumento', 45)->nullable();
            $table->string('numerodocumento', 45)->nullable();
            $table->dateTime('fecharegistro')->nullable();

            $table->primary(['idcompra', 'idpersona', 'idproveedor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compra');
    }
}
