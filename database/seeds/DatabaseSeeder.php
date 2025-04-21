<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->truncateTables([
            
            'provincias',
            'localidades',
            'categorias_entidad',
            'entidades',
            'users'
            
    	]);

        $this->call([
            ProvinciasSeeder::class,
            LocalidadesSeeder::class,
            CategoriasEntidadSeeder::class,
            EntidadesSeeder::class,
            UsersSeeder::class,
        ]);
    }

    //metodo para eliminar las tablas en cada ejecucion del seeder
    protected function truncateTables(array $tables){

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}