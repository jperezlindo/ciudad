<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre', 100);
            $table->string('marca', 100);
            $table->string('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('precio', 20, 2)->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('entidad_id');
            $table->foreign('entidad_id')->references('id')->on('entidades');
            $table->unsignedBigInteger('categoria_producto_servicio_id')->nullable();
            $table->string('au')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
