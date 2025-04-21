<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Provincias extends Migration
{
    public function up()
    {
        Schema::create('provincias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('pais',100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('provincias');
    }
}
