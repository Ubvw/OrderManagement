<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Burger',
            'description' => 'Juicy beef burger with cheese',
            'price' => 5.99,
            'stock' => 20,
        ]);

        Product::create([
            'name' => 'French Fries',
            'description' => 'Crispy fries with ketchup',
            'price' => 2.99,
            'stock' => 50,
        ]);
    }
}
