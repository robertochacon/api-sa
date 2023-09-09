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
            ['id_entity' => 1,'code' => '2023','name' => 'Administrador','role' => 'Administrador','password' => bcrypt('2023'), 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'code' => '2024','name' => 'Vendedor','role' => 'Vendedor','password' => bcrypt('2023'), 'created_at' => date("Y-m-d H:i:s")],
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
            ['id_entity' => 1,'category_id' => '1','name' => 'Bolitas de queso','description' => 'Ricas bolitas de queso','price' => '200'],
        ]);

        Storage::makeDirectory('public/products');

    }
}
