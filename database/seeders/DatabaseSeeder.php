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

        //users
        DB::table('users')->insert([
            ['code' => '2023','name' => 'Admin','password' => bcrypt('2023'), 'created_at' => date("Y-m-d H:i:s")],
        ]);

        //categories
        DB::table('categories')->insert([
            ['name' => 'Entradas', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Plato fuerte', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Especialidad', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Postre', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Bebidas', 'created_at' => date("Y-m-d H:i:s")],
        ]);

        //categories
        DB::table('products')->insert([
            ['category_id' => '1','name' => 'Bolitas de queso','description' => 'Ricas bolitas de queso','price' => '200'],
        ]);

        Storage::makeDirectory('public/products');

    }
}
