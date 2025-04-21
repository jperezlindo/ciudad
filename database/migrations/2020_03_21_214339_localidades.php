<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Localidades extends Migration
{
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('cod_postal',6);
            $table->string('cordenadas')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('logo')->nullable();
            $table->foreignId('provincia_id')->constrained();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}
