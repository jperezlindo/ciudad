<?php

use Illuminate\Database\Seeder;

class LocalidadesSeeder extends Seeder
{
    public function run(){

        DB::table('localidades')->insert([
            'nombre'       => 'JARDIN AMERICA',
            'cod_postal'   => '3328',
            'provincia_id' => 1
        ]);
    
        DB::table('localidades')->insert([
            'nombre'       => 'MONTECARLO',
            'cod_postal'   => '3384',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'POSADAS',
            'cod_postal'   => '3300',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'ELDORADO',
            'cod_postal'   => '3380',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'OBERA',
            'cod_postal'   => '3360',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'LEANDO N. ALEM',
            'cod_postal'   => '3315',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'PUERTO RICO',
            'cod_postal'   => '3334',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'PTO. IGUAZU',
            'cod_postal'   => '3370',
            'provincia_id' => 1
        ]);

        DB::table('localidades')->insert([
            'nombre'       => 'SAN IGNACIO',
            'cod_postal'   => '3322',
            'provincia_id' => 1
        ]);
    }
}
