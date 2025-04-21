<?php

use Illuminate\Database\Seeder;

class CategoriasEntidadSeeder extends Seeder
{
    public function run()
    {


        // comercios
       
        DB::table('categorias_entidad')->insert([
            'nombre' => 'DESARROLLO DE SOFTWARE',
            'descripcion'   => '',
            'categoria_id' => 1
        ]); 
        /*
        DB::table('categorias_entidad')->insert([
            'nombre' => 'AUTOSERVICIO',
            'descripcion'   => '',
            'categoria_id' => 1
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'KIOSKO/DESPENSA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'INDUMENTARIA/BOUTIQUE',
            'descripcion'   => '',
            'categoria_id' => 1
        ]); 


        DB::table('categorias_entidad')->insert([
            'nombre' => 'FERRETERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);


        DB::table('categorias_entidad')->insert([
            'nombre' => 'VETERINARIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'FARMACIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);
        

        DB::table('categorias_entidad')->insert([
            'nombre' => 'OPTICA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'RELOJERIA/JOYERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);
        
        DB::table('categorias_entidad')->insert([
            'nombre' => 'ARTICULOS HOGAR/OFICINA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);
        
        DB::table('categorias_entidad')->insert([
            'nombre' => 'FLORERIA/VIVERO',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);
        
        DB::table('categorias_entidad')->insert([
            'nombre' => 'CELULARES/ACCESORIOS',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);
      
        DB::table('categorias_entidad')->insert([
            'nombre' => 'REPUESTOS',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'MAQUINAS/HERRAMIENTAS',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'PINTURERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'CARNICERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'VERDULERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'LIBRERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'REPUESTOS',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'MUEBLERIA',
            'descripcion'   => '',
            'categoria_id' => 1
        ]);

        //SERVICIOS
        DB::table('categorias_entidad')->insert([
            'nombre' => 'SALON DE BELLEZA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'SOFTWARE',
            'descripcion'   => 'Diseño y desarrollo de sistemas de gestion, paginas web, etc.',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'HOSPITAL/CLINICA/SANATORIO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'TALLER MECANICO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'LUBRICENTRO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'REMISERIA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'DELIVERY/MANDADO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'REPARACION PC/CELULAR',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'LAVADERO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'LAVANDERIA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'ELECTRICISTA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);
        
        DB::table('categorias_entidad')->insert([
            'nombre' => 'PLOMERO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'JARDINERIA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'PAGO DE SERVICIOS',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);
        
        DB::table('categorias_entidad')->insert([
            'nombre' => 'CARPINTERO',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 
    
        DB::table('categorias_entidad')->insert([
            'nombre' => 'ALBAÑIL',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 
    
        DB::table('categorias_entidad')->insert([
            'nombre' => 'CERRAJERIA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'SALONES DE FIESTA',
            'descripcion'   => '',
            'categoria_id' => 2
        ]); 

        //turismo
        DB::table('categorias_entidad')->insert([
            'nombre' => 'HOTEL/APART',
            'descripcion'   => '',
            'categoria_id' => 3
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'CAPING/CABAÑA',
            'descripcion'   => '',
            'categoria_id' => 3
        ]); 

        //comidads bebidas
        DB::table('categorias_entidad')->insert([
            'nombre' => 'RESTAURANTE/COMEDOR/PARRILLA',
            'descripcion'   => '',
            'categoria_id' => 4
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'PIZZERIA/HAMBURGUESERIA',
            'descripcion'   => '',
            'categoria_id' => 4
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'BAR/PUB/CERVECERIA',
            'descripcion'   => '',
            'categoria_id' => 4
        ]);

        DB::table('categorias_entidad')->insert([
            'nombre' => 'HELADERIA',
            'descripcion'   => '',
            'categoria_id' => 4
        ]); 

        DB::table('categorias_entidad')->insert([
            'nombre' => 'PANADERIA/CONFITERIA',
            'descripcion'   => '',
            'categoria_id' => 4
        ]);
        */ 
    }

}
