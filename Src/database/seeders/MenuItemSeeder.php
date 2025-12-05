<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // تأكد من وجود categories
        if (DB::table('categories')->count() === 0) {
            $this->command->warn('No categories found! Seeding categories first...');
            $this->call(CategoriesTableSeeder::class);
        }
        
        $menuItems = [
            // Appetizers
            ['name' => 'Garlic Bread', 'price' => 4.99, 'size' => 'S', 'description' => 'Toasted bread with garlic butter and herbs', 'category_name' => 'Appetizers'],
            ['name' => 'Bruschetta', 'price' => 5.99, 'size' => 'M', 'description' => 'Toasted bread topped with tomatoes, garlic, and basil', 'category_name' => 'Appetizers'],
            
            // Main Courses
            ['name' => 'Grilled Salmon', 'price' => 22.99, 'size' => 'L', 'description' => 'Fresh salmon grilled with herbs and lemon', 'category_name' => 'Main Courses'],
            ['name' => 'Grilled Chicken', 'price' => 16.99, 'size' => 'L', 'description' => 'Grilled chicken breast with herbs and vegetables', 'category_name' => 'Main Courses'],
            
            // Pizza
            ['name' => 'Margherita Pizza', 'price' => 12.99, 'size' => 'M', 'description' => 'Classic pizza with tomato sauce, mozzarella, and fresh basil', 'category_name' => 'Pizza'],
            ['name' => 'Pepperoni Pizza', 'price' => 14.99, 'size' => 'L', 'description' => 'Pizza with pepperoni and extra cheese', 'category_name' => 'Pizza'],
            
            // Pasta
            ['name' => 'Spaghetti Carbonara', 'price' => 14.99, 'size' => 'L', 'description' => 'Pasta with eggs, cheese, pancetta, and black pepper', 'category_name' => 'Pasta'],
            
            // Salads
            ['name' => 'Caesar Salad', 'price' => 8.99, 'size' => 'M', 'description' => 'Fresh romaine lettuce with Caesar dressing, croutons and parmesan', 'category_name' => 'Salads'],
            
            // Burgers
            ['name' => 'Classic Burger', 'price' => 10.99, 'size' => 'M', 'description' => 'Beef burger with lettuce, tomato, onion, and special sauce', 'category_name' => 'Burgers'],
            
            // Desserts
            ['name' => 'Chocolate Lava Cake', 'price' => 6.99, 'size' => 'S', 'description' => 'Warm chocolate cake with a molten chocolate center', 'category_name' => 'Desserts'],
            
            // Drinks
            ['name' => 'Fresh Orange Juice', 'price' => 3.99, 'size' => 'M', 'description' => 'Freshly squeezed orange juice', 'category_name' => 'Drinks'],
            
            // Vegetarian
            ['name' => 'Vegetable Lasagna', 'price' => 13.99, 'size' => 'L', 'description' => 'Layers of pasta with vegetables and cheese sauce', 'category_name' => 'Vegetarian'],
            
            // Seafood
            ['name' => 'Shrimp Scampi', 'price' => 19.99, 'size' => 'L', 'description' => 'Shrimp cooked in garlic butter sauce', 'category_name' => 'Seafood'],
        ];

        foreach ($menuItems as $item) {
            $category = DB::table('categories')->where('name', $item['category_name'])->first();
            
            if (!$category) {
                $category = DB::table('categories')->first();
            }
            
            // استخدم insert فقط مع الأعمدة الموجودة
            DB::table('products')->insert([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'price' => $item['price'],
                'category_id' => $category->id,
                'is_active' => true,
                'size' => $item['size'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $count = DB::table('products')->count();
        $this->command->info("✅ Menu items seeded successfully! Total: {$count}");
    }
}