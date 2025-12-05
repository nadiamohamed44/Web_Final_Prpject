<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Categories
        $categories = ['pizza', 'burger', 'pasta', 'drinks', 'dessert'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }

        // Products
        // Map category names to IDs
        $catIds = Category::pluck('id', 'name');

        $products = [
            ['name' => "Pepperoni Pizza", 'price' => 250, 'image' => "P4.jpg", 'category' => "pizza"],
            ['name' => "Cheese Burger", 'price' => 180, 'image' => "B1.jpg", 'category' => "burger"],
            ['name' => "Chicken Pasta", 'price' => 200, 'image' => "Pasta1.jpg", 'category' => "pasta"],
            ['name' => "Cold Drink", 'price' => 50, 'image' => "DR1.jpg", 'category' => "drinks"],
            ['name' => "Chocolate Cake", 'price' => 90, 'image' => "D1.jpg", 'category' => "dessert"],
            ['name' => "Test Pizza", 'price' => 250, 'image' => "P1.jpg", 'category' => "pizza"],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $catIds[$p['category']],
                'name' => $p['name'],
                'description' => 'Delicious ' . $p['name'],
                'price' => $p['price'],
                'image_url' => $p['image'], // using filename as expected by JS
                'size' => 'M', // Default size
            ]);
        }
    }
}
