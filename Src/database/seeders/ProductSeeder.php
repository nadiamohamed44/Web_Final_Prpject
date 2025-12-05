<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // وجبات رئيسية
            ['name' => 'برجر لحم', 'description' => 'برجر لحم بقري طازج مع الخضار', 'price' => 85.00, 'category_id' => 1, 'stock' => 50, 'is_available' => true],
            ['name' => 'بيتزا مارجريتا', 'description' => 'بيتزا بالجبنة والطماطم', 'price' => 120.00, 'category_id' => 1, 'stock' => 30, 'is_available' => true],
            ['name' => 'دجاج مشوي', 'description' => 'دجاج مشوي مع الأرز', 'price' => 95.00, 'category_id' => 1, 'stock' => 40, 'is_available' => true],
            ['name' => 'باستا بالصوص الأبيض', 'description' => 'باستا كريمية لذيذة', 'price' => 75.00, 'category_id' => 1, 'stock' => 35, 'is_available' => true],

            // مقبلات
            ['name' => 'بطاطس مقلية', 'description' => 'بطاطس مقرمشة', 'price' => 25.00, 'category_id' => 2, 'stock' => 100, 'is_available' => true],
            ['name' => 'أجنحة دجاج', 'description' => 'أجنحة دجاج حارة', 'price' => 55.00, 'category_id' => 2, 'stock' => 60, 'is_available' => true],
            ['name' => 'سمبوسك', 'description' => 'سمبوسك باللحم', 'price' => 30.00, 'category_id' => 2, 'stock' => 80, 'is_available' => true],

            // حلويات
            ['name' => 'كيك الشوكولاتة', 'description' => 'كيك شوكولاتة غني', 'price' => 45.00, 'category_id' => 3, 'stock' => 25, 'is_available' => true],
            ['name' => 'آيس كريم', 'description' => 'آيس كريم بنكهات متنوعة', 'price' => 35.00, 'category_id' => 3, 'stock' => 50, 'is_available' => true],
            ['name' => 'تشيز كيك', 'description' => 'تشيز كيك كريمي', 'price' => 50.00, 'category_id' => 3, 'stock' => 20, 'is_available' => true],

            // مشروبات
            ['name' => 'عصير برتقال', 'description' => 'عصير برتقال طازج', 'price' => 20.00, 'category_id' => 4, 'stock' => 100, 'is_available' => true],
            ['name' => 'قهوة', 'description' => 'قهوة عربية أصيلة', 'price' => 15.00, 'category_id' => 4, 'stock' => 150, 'is_available' => true],
            ['name' => 'مشروب غازي', 'description' => 'مشروبات غازية متنوعة', 'price' => 10.00, 'category_id' => 4, 'stock' => 200, 'is_available' => true],

            // سلطات
            ['name' => 'سلطة خضراء', 'description' => 'سلطة خضار طازجة', 'price' => 30.00, 'category_id' => 5, 'stock' => 40, 'is_available' => true],
            ['name' => 'سلطة سيزر', 'description' => 'سلطة سيزر بالدجاج', 'price' => 55.00, 'category_id' => 5, 'stock' => 30, 'is_available' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
