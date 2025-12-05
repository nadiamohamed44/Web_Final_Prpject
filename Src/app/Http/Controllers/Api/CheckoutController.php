<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * ملخص الطلب قبل الدفع
     */
    public function summary()
    {
        $cart = $this->cartService->getCart();

        if ($this->cartService->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'العربة فارغة'
            ], 400);
        }

        $subtotal = $cart->total;
        $shipping = 35; // تكلفة التوصيل
        $tax = round($subtotal * 0.14, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        return response()->json([
            'success' => true,
            'data' => [
                'items_count' => $this->cartService->getItemsCount(),
                'subtotal'    => $subtotal,
                'shipping'    => $shipping,
                'tax'         => $tax,
                'total'       => $total,
                'items'       => $cart->items->map(function ($item) {
                    return [
                        'name'     => $item->menuItem->name ?? 'غير متوفر',
                        'quantity' => $item->quantity,
                        'price'    => $item->price,
                        'subtotal' => $item->quantity * $item->price,
                    ];
                })
            ]
        ]);
    }

    /**
     * إتمام الطلب والدفع
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash_on_delivery,credit_card,wallet',
            'address'        => 'required|string|max:500',
            'phone'          => 'required|string|max:20',
            'notes'          => 'nullable|string'
        ]);

        $cart = $this->cartService->getCart();

        if ($this->cartService->isEmpty()) {
            return response()->json([
                'success' => false, 
                'message' => 'العربة فارغة'
            ], 400);
        }

        DB::beginTransaction();
        
        try {
            // حساب المجاميع مباشرة بدون استدعاء method الـ summary
            $subtotal = $cart->total;
            $shipping = 35; // تكلفة التوصيل
            $tax = round($subtotal * 0.14, 2);
            $totalAmount = round($subtotal + $shipping + $tax, 2);

            // تأكد من وجود user
            if (!Auth::check()) {
                throw new \Exception('يجب تسجيل الدخول أولاً');
            }

            // إنشاء الطلب - استخدم الأسماء الصحيحة من الجدول
            $order = Order::create([
                'user_id'           => Auth::id(),
                'total' => $totalAmount,     // ⬅️ استخدم المتغير المحسوب مباشرة
                'status'            => 'pending',
                'payment_method'    => $request->payment_method,
                'payment_status'    => 'pending',
                'shipping_address'  => $request->address,     // ⬅️ الاسم في الجدول: shipping_address
                'phone'             => $request->phone,
                'notes'             => $request->notes,
            ]);

            // نقل العناصر من العربة للطلب
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'menu_item_id'   => $item->menu_item_id,
                    'quantity'       => $item->quantity,
                    'price'          => $item->price,
                ]);
                
                // تحديث مخزون المنتج
                $menuItem = MenuItem::find($item->menu_item_id);
                if ($menuItem) {
                    $menuItem->decrement('stock_quantity', $item->quantity);
                }
            }

            // تفريغ العربة بعد الدفع
            $this->cartService->clearCart();

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الطلب بنجاح',
                'data'    => [
                    'order_id' => $order->id,
                    'total' => $order->total,  // ⬅️ عدلي هنا أيضاً
                    'status'   => $order->status,
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'فشل في إنشاء الطلب: ' . $e->getMessage()
            ], 500);
        }
    }
}