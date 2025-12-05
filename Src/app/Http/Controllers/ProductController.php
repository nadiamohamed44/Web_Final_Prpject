<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function apiIndex()
    {
        $products = Product::with('category')->get()->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                // Ensure image path is correct relative to what front-end expects or uses
                // If stored in 'public/assets', we return filename if JS updates path, or full URL
                'image' => $product->image_url,
                'category' => $product->category ? strtolower($product->category->name) : 'other',
            ];
        });

        return response()->json($products);
    }
}
