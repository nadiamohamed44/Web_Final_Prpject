<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductRepository
{
    public function getFilteredProducts(array $filters)
    {
        $query = Product::with('category');

        // Filter by is_active
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        // Filter by category
        if (!empty($filters['category'])) {
            if (is_numeric($filters['category'])) {
                $query->where('category_id', $filters['category']);
            } else {
                $query->whereHas('category', function ($q) use ($filters) {
                    $q->where('slug', $filters['category'])
                      ->orWhere('name', 'like', '%' . $filters['category'] . '%');
                });
            }
        }

        // Search by name or description
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Price range filter
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function findById($id)
    {
        return Product::with('category')->find($id);
    }

    public function create(array $data)
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return null;
        }

        // Update slug if name changed
        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}