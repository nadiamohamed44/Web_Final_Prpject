<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    /**
     * Get current user's cart or create new one
     * @return Cart
     */
    public function getCart()
    {
        $user = Auth::user();
        
        if ($user) {
            // للمستخدمين المسجلين
            $cart = $user->cart;
            
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'total' => 0
                ]);
            }
        } else {
            // للضيوف - استخدم temporary user
            $guestUser = $this->getOrCreateGuestUser();
            
            $cart = Cart::firstOrCreate(
                ['user_id' => $guestUser->id],
                ['total' => 0]
            );
        }

        return $cart->load('items.menuItem');
    }

    /**
     * Get or create guest user for anonymous carts
     * @return User
     */
    protected function getOrCreateGuestUser()
    {
        // ابحث عن user مخصص للضيوف أو أنشئه
        $guestUser = User::where('email', 'like', 'guest_%')->first();
        
        if (!$guestUser) {
            $guestUser = User::create([
                'first_name' => 'Guest',
                'last_name' => 'User',
                'email' => 'guest_' . time() . '@example.com',
                'password' => bcrypt(Str::random(16))
            ]);
        }
        
        return $guestUser;
    }

    /**
     * Add item to cart (CRUD - Create)
     * @param int $menuItemId
     * @param int $quantity
     * @return Cart
     */
    public function addItem($menuItemId, $quantity = 1)
    {
        // التحقق من وجود المنتج
        $menuItem = MenuItem::findOrFail($menuItemId);

        // التحقق من توفر المنتج
        if (!$menuItem->is_available) {
            throw new \Exception('This item is not available');
        }

        $cart = $this->getCart();

        // البحث عن العنصر في السلة - استخدم product_id بدل menu_item_id
        $cartItem = $cart->items()->where('product_id', $menuItemId)->first();

        if ($cartItem) {
            // تحديث الكمية إذا كان موجود
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity
            ]);
        } else {
            // إضافة عنصر جديد - استخدم product_id بدل menu_item_id
            $cart->items()->create([
                'product_id' => $menuItemId,
                'quantity' => $quantity,
                'price' => $menuItem->price
            ]);
        }

        // إعادة حساب الإجمالي
        $this->recalculateTotal($cart);

        return $cart->fresh()->load('items.menuItem');
    }

    /**
     * Update cart item quantity (CRUD - Update)
     * @param int $cartItemId
     * @param int $quantity
     * @return Cart
     */
    public function updateItem($cartItemId, $quantity)
    {
        $cart = $this->getCart();
        $item = $cart->items()->findOrFail($cartItemId);

        if ($quantity <= 0) {
            // حذف العنصر إذا كانت الكمية صفر أو أقل
            $item->delete();
        } else {
            // تحديث الكمية
            $item->update(['quantity' => $quantity]);
        }

        $this->recalculateTotal($cart);
        
        return $cart->fresh()->load('items.menuItem');
    }

    /**
     * Remove item from cart (CRUD - Delete)
     * @param int $cartItemId
     * @return Cart
     */
    public function removeItem($cartItemId)
    {
        $cart = $this->getCart();
        
        $item = $cart->items()->findOrFail($cartItemId);
        $item->delete();

        $this->recalculateTotal($cart);
        
        return $cart->fresh()->load('items.menuItem');
    }

    /**
     * Clear all items from cart
     * @return Cart
     */
    public function clearCart()
    {
        $cart = $this->getCart();
        
        // حذف جميع العناصر
        $cart->items()->delete();
        
        // تصفير الإجمالي
        $cart->update(['total' => 0]);
        
        return $cart;
    }

    /**
     * Recalculate cart total
     * @param Cart $cart
     * @return void
     */
    protected function recalculateTotal($cart)
    {
        // حساب المجموع: الكمية × السعر لكل عنصر
        $total = $cart->items()->sum(DB::raw('quantity * price'));
        
        $cart->update(['total' => $total]);
    }

    /**
     * Get cart items count
     * @return int
     */
    public function getItemsCount()
    {
        $cart = $this->getCart();
        return $cart->items()->sum('quantity');
    }

    /**
     * Check if cart is empty
     * @return bool
     */
    public function isEmpty()
    {
        $cart = $this->getCart();
        return $cart->items()->count() === 0;
    }
}