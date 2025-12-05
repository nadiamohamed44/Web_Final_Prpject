<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'وجبات رئيسية', 'description' => 'أطباق رئيسية متنوعة'],
            ['name' => 'مقبلات', 'description' => 'مقبلات شهية'],
            ['name' => 'حلويات', 'description' => 'حلويات لذيذة'],
            ['name' => 'مشروبات', 'description' => 'مشروبات باردة وساخنة'],
            ['name' => 'سلطات', 'description' => 'سلطات طازجة'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
