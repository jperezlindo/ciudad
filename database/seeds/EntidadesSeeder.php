<?php

use Illuminate\Database\Seeder;

class EntidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entidades')->insert([
            'cuit'       => '20000000009',
            'nombre'   => 'GO-Developers',
            'direccion' => 'JARDIN AMERICA',
            'email' => 'godevelopers@gmail.com',
            'tel_cel' => '3743445563',
            'logo' => 'entidad.jpg',
            'localidad_id' => 1,
            'categoria_entidad_id' => 1
        ]);
    }
}
