<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Get checkout summary with calculations
     * @return array
     */
    public function getSummary()
    {
        $cart = $this->cartService->getCart();
        
        // التحقق من أن السلة ليست فارغة
        if ($cart->items->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $subtotal = $cart->total;
        $taxRate = 0.14; // 14% ضريبة القيمة المضافة
        $tax = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $tax, 2);

        return [
            'items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'menu_item' => [
                        'id' => $item->menuItem->id,
                        'name' => $item->menuItem->name,
                        'price' => $item->menuItem->price,
                    ],
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->quantity * $item->price
                ];
            }),
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax' => $tax,
            'total' => $total,
            'items_count' => $cart->items->sum('quantity')
        ];
    }

    /**
     * Process checkout and create order
     * @param string $paymentMethod
     * @return Order
     */
    public function processCheckout($paymentMethod = 'cash')
    {
        DB::beginTransaction();
        
        try {
            // الحصول على السلة
            $cart = $this->cartService->getCart();
            
            // التحقق من أن السلة ليست فارغة
            if ($cart->items->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            // التحقق من أن المستخدم مسجل دخول
            if (!Auth::check()) {
                throw new \Exception('User must be logged in to checkout');
            }

            // حساب المجاميع
            $summary = $this->getSummary();

            // إنشاء الطلب
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $summary['total'],
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending'
            ]);

            // نسخ العناصر من السلة إلى الطلب
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'menu_item_id' => $item->menu_item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);
            }

            // مسح السلة بعد إنشاء الطلب
            $this->cartService->clearCart();

            DB::commit();
            
            // إرجاع الطلب مع العناصر
            return $order->load('items.menuItem');
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Calculate totals for given cart
     * @param float $subtotal
     * @return array
     */
    public function calculateTotals($subtotal)
    {
        $taxRate = 0.14;
        $tax = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $tax, 2);

        return [
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax' => $tax,
            'total' => $total
        ];
    }

    /**
     * Validate payment method
     * @param string $paymentMethod
     * @return bool
     */
    public function isValidPaymentMethod($paymentMethod)
    {
        $allowedMethods = ['cash', 'card', 'online'];
        return in_array($paymentMethod, $allowedMethods);
    }

    /**
     * Payment integration stub - للربط مع بوابة الدفع لاحقاً
     * @param Order $order
     * @param string $paymentMethod
     * @return array
     */
    public function processPayment($order, $paymentMethod)
    {
        // هنا يتم الربط مع بوابة الدفع (Stripe, PayPal, Fawry, إلخ)
        // حالياً هنرجع response وهمي
        
        if ($paymentMethod === 'cash') {
            // الدفع عند الاستلام
            return [
                'success' => true,
                'message' => 'Cash on delivery selected',
                'transaction_id' => null
            ];
        }

        // Payment gateway integration stub
        // TODO: Integrate with actual payment gateway
        return [
            'success' => false,
            'message' => 'Payment gateway not implemented yet',
            'transaction_id' => null
        ];
    }
}