<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->unsignedInteger('idproducto')->primary();
            $table->string('codigo', 45)->nullable();
            $table->string('nombre', 45)->nullable();
            $table->string('descripcion', 45)->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('preciocompra', 10)->nullable();
            $table->decimal('precioventa', 10)->nullable();
            $table->boolean('estado')->nullable();
            $table->dateTime('fecharegistro')->nullable();
            $table->unsignedInteger('idcategoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
