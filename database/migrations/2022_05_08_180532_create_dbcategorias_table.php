<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbcategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dbcategorias', function (Blueprint $table) {
            $table->text('Categorias')->nullable();
            $table->text('MyUnknownColumn')->nullable();
            $table->text('MyUnknownColumn_[0]')->nullable();
            $table->text('MyUnknownColumn_[1]')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dbcategorias');
    }
}
