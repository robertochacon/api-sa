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
            ['name' => 'Entradas'],
            ['name' => 'Plato fuerte'],
            ['name' => 'Postre'],
            ['name' => 'Bebidas'],
        ]);

        //categories
        DB::table('products')->insert([
            ['category_id' => '1','name' => 'Bolitas de queso','description' => 'Ricas bolitas de queso','price' => '200'],
        ]);
    }
}
