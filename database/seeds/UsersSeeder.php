<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	static $password;

        DB::table('users')->insert([
			'dni'              => '34821622',
			'apellido'         => 'PEREZLINDO',
			'nombre'           => 'JOSE ARIEL',
			'email'            => 'perzlindo@gmail.com',
			'rol_id'		   => 1,
			'entidad_id'	   => 1,
			'password'         => Hash::make('123456789'),
			'remember_token'   => Str::random(10),

        ]);

        DB::table('users')->insert([
			'dni'              => '35007110',
			'apellido'         => 'BERGMEIER',
			'nombre'           => 'ADRIAN',
			'email'            => 'adrianbergmeier15@gmail.com',
			'rol_id'		   => 1,
			'entidad_id'	   => 1,
			'password'         => Hash::make('123456789'),
			'remember_token'   => Str::random(10),

		]);
		
        DB::table('users')->insert([
			'dni'              => '00000000',
			'apellido'         => 'go',
			'nombre'           => 'developers',
			'email'            => 'godevelopers@gmail.com',
			'rol_id'		   => 2,
			'entidad_id'	   => 1,
			'password'         => Hash::make('00000000'),
			'remember_token'   => Str::random(10),

        ]);
    }
}
