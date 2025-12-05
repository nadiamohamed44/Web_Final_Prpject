<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الفئات
        $categories = [
            ['name' => 'بيتزا', 'slug' => 'pizza', 'is_active' => true],
            ['name' => 'برجر', 'slug' => 'burger', 'is_active' => true],
            ['name' => 'مشروبات', 'slug' => 'drinks', 'is_active' => true],
            ['name' => 'حلويات', 'slug' => 'desserts', 'is_active' => true],
        ];
        
        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
        
        // إنشاء المنتجات
        $products = [
            [
                'name' => 'بيتزا مارغريتا',
                'slug' => 'margherita-pizza',
                'description' => 'بيتزا كلاسيكية بصلصة الطماطم والموزاريلا',
                'price' => 25.99,
                'category_id' => 1,
                'is_available' => true,
                'is_featured' => true
            ],
            [
                'name' => 'بيتزا بيبروني',
                'slug' => 'pepperoni-pizza',
                'description' => 'بيتزا مع بيبروني وجبنة موزاريلا',
                'price' => 29.99,
                'discount_price' => 24.99,
                'category_id' => 1,
                'is_available' => true
            ],
            [
                'name' => 'برجر لحم',
                'slug' => 'beef-burger',
                'description' => 'برجر لحم بقري مع خضار وجبنة',
                'price' => 18.50,
                'category_id' => 2,
                'is_available' => true,
                'is_featured' => true
            ],
            [
                'name' => 'كولا',
                'slug' => 'cola',
                'description' => 'مشروب غازي',
                'price' => 5.00,
                'category_id' => 3,
                'is_available' => true
            ],
        ];
        
        foreach ($products as $productData) {
            Product::create($productData);
        }
        
        echo "تم إنشاء " . Category::count() . " فئات و " . Product::count() . " منتجات\n";
    }
}