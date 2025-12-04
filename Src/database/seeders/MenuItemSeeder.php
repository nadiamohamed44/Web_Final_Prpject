<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $menuItems = [
            // Pizzas
            ['name' => 'Margherita Pizza', 'price' => 85.00, 'is_available' => true],
            ['name' => 'Pepperoni Pizza', 'price' => 95.00, 'is_available' => true],
            ['name' => 'Vegetarian Pizza', 'price' => 90.00, 'is_available' => true],
            ['name' => 'BBQ Chicken Pizza', 'price' => 110.00, 'is_available' => true],
            ['name' => 'Four Cheese Pizza', 'price' => 100.00, 'is_available' => true],
            
            // Burgers
            ['name' => 'Classic Beef Burger', 'price' => 65.00, 'is_available' => true],
            ['name' => 'Chicken Burger', 'price' => 60.00, 'is_available' => true],
            ['name' => 'Cheese Burger', 'price' => 70.00, 'is_available' => true],
            ['name' => 'Double Burger', 'price' => 85.00, 'is_available' => true],
            ['name' => 'Veggie Burger', 'price' => 55.00, 'is_available' => true],
            
            // Sides
            ['name' => 'French Fries', 'price' => 25.00, 'is_available' => true],
            ['name' => 'Onion Rings', 'price' => 30.00, 'is_available' => true],
            ['name' => 'Mozzarella Sticks', 'price' => 40.00, 'is_available' => true],
            ['name' => 'Chicken Wings', 'price' => 55.00, 'is_available' => true],
            ['name' => 'Caesar Salad', 'price' => 45.00, 'is_available' => true],
            
            // Drinks
            ['name' => 'Coca Cola', 'price' => 15.00, 'is_available' => true],
            ['name' => 'Pepsi', 'price' => 15.00, 'is_available' => true],
            ['name' => 'Sprite', 'price' => 15.00, 'is_available' => true],
            ['name' => 'Orange Juice', 'price' => 20.00, 'is_available' => true],
            ['name' => 'Water', 'price' => 10.00, 'is_available' => true],
            
            // Desserts
            ['name' => 'Chocolate Cake', 'price' => 45.00, 'is_available' => true],
            ['name' => 'Ice Cream', 'price' => 30.00, 'is_available' => true],
            ['name' => 'Cheesecake', 'price' => 50.00, 'is_available' => true],
            ['name' => 'Brownie', 'price' => 35.00, 'is_available' => true],
            ['name' => 'Apple Pie', 'price' => 40.00, 'is_available' => true],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }

        echo "✅ Added " . count($menuItems) . " menu items successfully!\n";
    }
}