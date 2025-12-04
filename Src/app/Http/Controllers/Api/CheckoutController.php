<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // ملخص الطلب قبل الدفع
    public function summary()
    {
        $cart = $this->cartService->getCart();

        if ($this->cartService->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'العربة فارغة'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'items_count' => $this->cartService->getItemsCount(),
                'subtotal'    => $cart->total,
                'shipping'    => 35,
                'tax'         => round($cart->total * 0.14, 2),
                'total'       => round($cart->total + 35 + ($cart->total * 0.14), 2),
                'items'       => $cart->items->map(fn($i) => [
                    'name'     => $i->menuItem->name,
                    'quantity' => $i->quantity,
                    'price'    => $i->price,
                    'subtotal' => $i->quantity * $i->price,
                ])
            ]
        ]);
    }

    // إتمام الطلب والدفع
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash_on_delivery,credit_card,wallet',
            'address'        => 'required|string|max:500',
            'phone'          => 'required|string|max:20',
            'notes'             => 'nullable|string'
        ]);

        $cart = $this->cartService->getCart();

        if ($this->cartService->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'العربة فارغة'], 400);
        }

        // إنشئ الطلب
        $order = Order::create([
            'user_id'        => Auth::id(),
            'total'          => $cart->total,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'address'        => $request->address,
            'phone'          => $request->phone,
            'notes'          => $request->notes,
        ]);

        // نقل العناصر من العربة للطلب
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'       => $order->id,
                'menu_item_id'   => $item->menu_item_id,
                'quantity'       => $item->quantity,
                'price'          => $item->price,
            ]);
        }

        // تفريغ العربة بعد الدفع
        $this->cartService->clearCart();

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الطلب بنجاح',
            'data'    => [
                'order_id' => $order->id,
                'total'    => $order->total,
                'status'   => $order->status,
            ]
        ], 201);
    }
}