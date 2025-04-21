<?php

use Illuminate\Database\Seeder;

class ProvinciasSeeder extends Seeder
{
    public function run(){
        DB::table('provincias')->insert([
            'nombre' => 'MISIONES',
            'pais'   => 'Argentina',
        ]);

        DB::table('provincias')->insert([
            'nombre' => 'CORRIENTES',
            'pais'   => 'Argentina',
        ]);

        DB::table('provincias')->insert([
            'nombre' => 'CHACO',
            'pais'   => 'Argentina',
        ]);

        DB::table('provincias')->insert([
            'nombre' => 'ENTRE RIOS',
            'pais'   => 'Argentina',
        ]);
    }
}
