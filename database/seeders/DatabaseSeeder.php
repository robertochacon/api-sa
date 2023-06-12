<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ['name' => 'Admin','email' => 'admin@gmail.com','password' => bcrypt('admin')],
        ]);

        //categories
        DB::table('categories')->insert([
            ['name' => 'Categoria 1'],
            ['name' => 'Categoria 2'],
        ]);

        //categories
        DB::table('products')->insert([
            ['category_id' => '1','name' => 'Producto 1','description' => 'Ejemplo descripcion 1','price' => '500'],
        ]);
    }
}
