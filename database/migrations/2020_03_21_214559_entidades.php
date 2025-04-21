<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Entidades extends Migration
{

        
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->id();
            $table->string('cuit',15)->unique();
            $table->string('nombre',100);
            $table->string('direccion');
            $table->string('coordenadas')->nullable();
            $table->string('email',100)->unique();
            $table->string('tel_cel',20);
            $table->string('logo')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('localidad_id');
            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->unsignedBigInteger('categoria_entidad_id');
            $table->foreign('categoria_entidad_id')->references('id')->on('categorias_entidad');
            $table->string('or')->nullable();
            $table->string('au')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entidades');
    }
    
}
