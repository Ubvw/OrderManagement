<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed products
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

        // Seed roles if they don't exist
        foreach (['Admin', 'Cashier', 'Food Processor'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => Role::where('name', 'Admin')->value('id'),
            ]
        );
    }
}
