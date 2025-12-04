<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الفئات
        $categories = [
            [
                'name' => 'بيتزا',
                'slug' => 'pizza',
                'description' => 'أشهى أنواع البيتزا'
            ],
            [
                'name' => 'برجر',
                'slug' => 'burger', 
                'description' => 'ألذ البرجر الطازج'
            ],
            [
                'name' => 'مقبلات',
                'slug' => 'appetizers',
                'description' => 'مقبلات لذيذة'
            ],
            [
                'name' => 'مشروبات',
                'slug' => 'drinks',
                'description' => 'مشروبات منعشة'
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // إنشاء منتجات تجريبية
        $pizzaCategory = Category::where('slug', 'pizza')->first();
        $burgerCategory = Category::where('slug', 'burger')->first();

        $products = [
            [
                'name' => 'بيتزا بيبروني',
                'slug' => Str::slug('بيتزا بيبروني'),
                'description' => 'بيتزا لذيذة مع جبنة موزاريلا وبيبروني',
                'price' => 45.00,
                'discount_price' => 39.99,
                'category_id' => $pizzaCategory->id,
                'preparation_time' => 20,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'بيتزا مارجريتا',
                'slug' => Str::slug('بيتزا مارجريتا'),
                'description' => 'بيتزا كلاسيكية مع طماطم وجبنة موزاريلا',
                'price' => 35.00,
                'category_id' => $pizzaCategory->id,
                'preparation_time' => 15,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'برجر لحم',
                'slug' => Str::slug('برجر لحم'),
                'description' => 'برجر لحم بقري طازج مع خضار',
                'price' => 35.00,
                'category_id' => $burgerCategory->id,
                'preparation_time' => 15,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'برجر دجاج',
                'slug' => Str::slug('برجر دجاج'),
                'description' => 'برجر دجاج مشوي مع صلصة خاصة',
                'price' => 30.00,
                'discount_price' => 25.99,
                'category_id' => $burgerCategory->id,
                'preparation_time' => 12,
                'is_available' => true,
                'is_featured' => false,
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ Categories and products seeded successfully!');
    }
}