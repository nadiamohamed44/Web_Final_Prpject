<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Exception;

class CartController extends Controller
{
    protected $cartService;

    // Dependency Injection (Laravel هيحقن الـ Service تلقائيًا)
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * عرض محتويات العربة
     */
    public function index()
    {
        try {
            $cart = $this->cartService->getCart();

            return response()->json([
                'success' => true,
                'data' => [
                    'cart_id' => $cart->id,
                    'total' => $cart->total,
                    'items_count' => $this->cartService->getItemsCount(),
                    'items' => $cart->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'menu_item_id' => $item->menu_item_id,
                            'name' => $item->menuItem->name ?? 'غير متوفر',
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'subtotal' => $item->quantity * $item->price,
                            'image' => $item->menuItem->image ?? null,
                        ];
                    }),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في جلب العربة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إضافة منتج للعربة
     */
    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'nullable|integer|min:1|max:50'
        ]);

        try {
            $cart = $this->cartService->addItem(
                $request->menu_item_id,
                $request->quantity ?? 1
            );

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المنتج إلى العربة بنجاح',
                'data' => [
                    'total' => $cart->total,
                    'items_count' => $this->cartService->getItemsCount(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * تحديث كمية عنصر في العربة
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:100'
        ]);

        try {
            $cart = $this->cartService->updateItem($cartItemId, $request->quantity);

            return response()->json([
                'success' => true,
                'message' => $request->quantity == 0 
                    ? 'تم حذف المنتج من العربة' 
                    : 'تم تحديث الكمية بنجاح',
                'data' => [
                    'total' => $cart->total,
                    'items_count' => $this->cartService->getItemsCount(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود في عربتك'
            ], 404);
        }
    }

    /**
     * حذف عنصر من العربة
     */
    public function remove($cartItemId)
    {
        try {
            $cart = $this->cartService->removeItem($cartItemId);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج من العربة',
                'data' => [
                    'total' => $cart->total,
                    'items_count' => $this->cartService->getItemsCount(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }
    }

    /**
     * تفريغ العربة كاملة
     */
    public function clear()
    {
        $this->cartService->clearCart();

        return response()->json([
            'success' => true,
            'message' => 'تم تفريغ العربة بنجاح',
            'data' => [
                'total' => 0,
                'items_count' => 0
            ]
        ]);
    }

    /**
     * عدد المنتجات في العربة (للـ Badge في الهيدر)
     */
    public function count()
    {
        return response()->json([
            'success' => true,
            'count' => $this->cartService->getItemsCount()
        ]);
    }
}