<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * GET /api/menu
     * جلب كل المنتجات مع الفلاتر
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Product::with('category')->where('is_available', true);
            
            // تطبيق الفلاتر
            // فلترة حسب الفئة
            if ($request->has('category')) {
                if (is_numeric($request->category)) {
                    $query->where('category_id', $request->category);
                } else {
                    // لو كان اسم الفئة
                    $query->whereHas('category', function($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->category . '%');
                    });
                }
            }
            
            // بحث بالاسم أو الوصف
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            // فلترة حسب السعر
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }
            
            // المنتجات المميزة فقط
            if ($request->has('featured') && $request->featured == 'true') {
                $query->where('is_featured', true);
            }
            
            // الترتيب
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // التقسيم
            $perPage = $request->get('per_page', 12);
            $products = $query->paginate($perPage);
            
            // إضافة الحقول المحسوبة
            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'price' => (float) $product->price,
                    'discount_price' => $product->discount_price ? (float) $product->discount_price : null,
                    'final_price' => (float) $product->final_price,
                    'has_discount' => $product->has_discount,
                    'image' => $product->image,
                    'image_url' => $product->image_url,
                    'is_available' => $product->is_available,
                    'is_featured' => $product->is_featured,
                    'preparation_time' => $product->preparation_time,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'تم جلب المنتجات بنجاح',
                'data' => $products->items(),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'has_more_pages' => $products->hasMorePages(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب المنتجات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/menu/{id}
     * جلب منتج محدد
     */
    public function show($id): JsonResponse
    {
        try {
            // البحث بالـ ID أو الـ Slug
            if (is_numeric($id)) {
                $product = Product::with('category')->find($id);
            } else {
                $product = Product::with('category')->where('slug', $id)->first();
            }
            
            if (!$product || !$product->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود أو غير متاح'
                ], 404);
            }
            
            $data = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => (float) $product->price,
                'discount_price' => $product->discount_price ? (float) $product->discount_price : null,
                'final_price' => (float) $product->final_price,
                'has_discount' => $product->has_discount,
                'image' => $product->image,
                'image_url' => $product->image_url,
                'is_available' => $product->is_available,
                'is_featured' => $product->is_featured,
                'preparation_time' => $product->preparation_time,
                'category' => $product->category ? [
                    'id' => $product->category->id,
                    'name' => $product->category->name
                ] : null,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'تم جلب المنتج بنجاح',
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب المنتج',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/menu/categories
     * جلب كل الفئات
     */
    public function categories(): JsonResponse
    {
        try {
            $categories = Category::whereHas('products', function($query) {
                $query->where('is_available', true);
            })->get();
            
            return response()->json([
                'success' => true,
                'message' => 'تم جلب الفئات بنجاح',
                'data' => $categories
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب الفئات',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}