<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Appetizers', 'Main Courses', 'Desserts', 'Drinks', 
            'Salads', 'Pizza', 'Pasta', 'Burgers', 'Seafood', 'Vegetarian'
        ];

        foreach ($categories as $categoryName) {
            DB::table('categories')->insert([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('✅ Categories seeded successfully! Total: ' . count($categories));
    }
}