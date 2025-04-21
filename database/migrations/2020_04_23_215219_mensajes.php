<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mensajes extends Migration
{
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('usuario',100);
            $table->string('contacto',100);
            $table->string('localidad',100)->nullable();
            $table->text('comentario');
            $table->boolean('leido')->default(false);
            $table->boolean('cliente')->default(false);
            $table->boolean('entidad_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('mensajes');
    }
}
