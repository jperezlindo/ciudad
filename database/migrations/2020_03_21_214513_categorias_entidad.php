<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoriasEntidad extends Migration
{
    public function up()
    {
        Schema::create('categorias_entidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('categorias_entidad');
    }
}
