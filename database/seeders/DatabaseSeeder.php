<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //entities
        DB::table('entities')->insert([
            ['name' => 'Example bussines','description' => 'business example desc.','phone' => null, 'created_at' => date("Y-m-d H:i:s")],
        ]);

        //users
        DB::table('users')->insert([
            ['id_entity' => 1,'code' => '0000','name' => 'Gestor','role' => 'Gestor','password' => bcrypt('2023'), 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'code' => '0001','name' => 'Administrador','role' => 'Administrador','password' => bcrypt('2023'), 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'code' => '0002','name' => 'Vendedor','role' => 'Vendedor','password' => bcrypt('2023'), 'created_at' => date("Y-m-d H:i:s")],
        ]);

        //categories
        DB::table('categories')->insert([
            ['id_entity' => 1,'name' => 'Entradas', 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'name' => 'Platos fuertes', 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'name' => 'Especialidades', 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'name' => 'Postres', 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'name' => 'Bebidas', 'created_at' => date("Y-m-d H:i:s")],
        ]);

        //categories
        DB::table('products')->insert([
            ['id_entity' => 1,'category_id' => '1','name' => 'Bolitas de queso','description' => 'Ricas bolitas de queso','price' => '250'],
            ['id_entity' => 1,'category_id' => '1','name' => 'Nachos de yautia','description' => 'Nachos de yautia','price' => '250'],
            ['id_entity' => 1,'category_id' => '2','name' => 'Mofongo','description' => 'Mofongo','price' => '390'],
            ['id_entity' => 1,'category_id' => '4','name' => 'Cheesecake','description' => 'Cheesecake','price' => '180'],
            ['id_entity' => 1,'category_id' => '4','name' => 'Bolitas de coco','description' => 'Bolitas de coco','price' => '150'],
            ['id_entity' => 1,'category_id' => '5','name' => 'Botella de agua','description' => 'Botella de agua','price' => '50'],
            ['id_entity' => 1,'category_id' => '5','name' => 'Jugo de fresa','description' => 'Jugo de fresa','price' => '125'],
            ['id_entity' => 1,'category_id' => '5','name' => 'Mojito','description' => 'Mojito','price' => '125'],
        ]);

        Storage::makeDirectory('public/products');

    }
}
