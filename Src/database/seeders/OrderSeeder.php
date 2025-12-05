<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // احصل على مستخدم للطلبات (أو اعمل واحد)
        $user = User::where('is_admin', false)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'عميل تجريبي',
                'email' => 'customer@test.com',
                'password' => bcrypt('password'),
                'phone' => '01234567890',
                'is_admin' => false
            ]);
        }

        // اعمل 10 طلبات تجريبية
        for ($i = 1; $i <= 10; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => rand(50, 500),
                'status' => ['pending', 'processing', 'completed', 'cancelled'][rand(0, 3)],
                'payment_method' => 'cash',
                'delivery_address' => 'عنوان تجريبي ' . $i,
                'phone' => '0123456789' . $i,
                'created_at' => now()->subDays(rand(0, 30))
            ]);

            // أضف منتجات للطلب
            $numItems = rand(1, 4);
            for ($j = 0; $j < $numItems; $j++) {
                $product = Product::inRandomOrder()->first();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price
                ]);
            }

            // حدّث إجمالي الطلب
            $order->update([
                'total' => $order->items->sum(function($item) {
                    return $item->quantity * $item->price;
                })
            ]);
        }
    }
}
