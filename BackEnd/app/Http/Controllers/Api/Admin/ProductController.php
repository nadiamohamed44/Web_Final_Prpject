<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * GET /api/admin/menu
     * عرض جميع المنتجات للإدارة
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Product::with('category');
            
            // تطبيق الفلاتر
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('category', function($q2) use ($search) {
                          $q2->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            
            if ($request->has('is_available')) {
                $query->where('is_available', $request->is_available == 'true');
            }
            
            if ($request->has('is_featured')) {
                $query->where('is_featured', $request->is_featured == 'true');
            }
            
            // إظهار المحذوفة إذا طلب
            if ($request->has('with_trashed') && $request->with_trashed == 'true') {
                $query->withTrashed();
            }
            
            // الترتيب
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // التقسيم
            $perPage = $request->get('per_page', 15);
            $products = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'message' => 'تم جلب المنتجات بنجاح',
                'data' => $products->items(),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total()
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
     * POST /api/admin/menu
     * إنشاء منتج جديد
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            // رفع الصورة إذا وجدت
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
            }
            
            $product = Product::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء المنتج بنجاح',
                'data' => $product->load('category')
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إنشاء المنتج',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /api/admin/menu/{id}
     * تحديث منتج موجود
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        try {
            $product = Product::find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            $data = $request->validated();
            
            // رفع صورة جديدة إذا وجدت
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                
                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
            }
            
            $product->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث المنتج بنجاح',
                'data' => $product->fresh()->load('category')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحديث المنتج',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/admin/menu/{id}
     * حذف منتج
     */
    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            $product->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج بنجاح'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حذف المنتج',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/admin/menu/{id}/restore
     * استعادة منتج محذوف
     */
    public function restore($id): JsonResponse
    {
        try {
            $product = Product::withTrashed()->find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            $product->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'تم استعادة المنتج بنجاح',
                'data' => $product->load('category')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في استعادة المنتج',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/admin/menu/{id}/force
     * حذف نهائي
     */
    public function forceDelete($id): JsonResponse
    {
        try {
            $product = Product::withTrashed()->find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            // حذف الصورة إذا كانت موجودة
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->forceDelete();
            
            return response()->json([
                'success' => true,
                'message' => 'تم الحذف النهائي للمنتج بنجاح'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الحذف النهائي',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/admin/menu/{id}/toggle-availability
     * تبديل حالة التوفر
     */
    public function toggleAvailability($id): JsonResponse
    {
        try {
            $product = Product::find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            $product->update(['is_available' => !$product->is_available]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم تبديل حالة التوفر بنجاح',
                'data' => [
                    'is_available' => $product->fresh()->is_available
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تبديل حالة التوفر',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/admin/menu/{id}/toggle-featured
     * تبديل حالة التميز
     */
    public function toggleFeatured($id): JsonResponse
    {
        try {
            $product = Product::find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            $product->update(['is_featured' => !$product->is_featured]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم تبديل حالة التميز بنجاح',
                'data' => [
                    'is_featured' => $product->fresh()->is_featured
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تبديل حالة التميز',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}