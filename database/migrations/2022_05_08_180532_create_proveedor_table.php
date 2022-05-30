<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->unsignedInteger('idproveedor')->primary();
            $table->string('documento', 45)->nullable();
            $table->string('razonsocial', 45)->nullable();
            $table->string('correo', 45)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->boolean('estado')->nullable();
            $table->dateTime('fecharegistro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedor');
    }
}
