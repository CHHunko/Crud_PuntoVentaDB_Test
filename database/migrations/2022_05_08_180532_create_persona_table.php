<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->unsignedInteger('idpersona');
            $table->string('documento', 45)->nullable();
            $table->string('nombre', 45)->nullable();
            $table->string('direccion', 45)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('password', 45)->nullable();
            $table->unsignedInteger('idtipopersona')->index('fk_persona_tipopersona1_idx');
            $table->boolean('estado')->nullable();
            $table->string('fechacreacion', 45)->nullable();
            $table->rememberToken();

            $table->primary(['idpersona', 'idtipopersona']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
