<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\DTOs\ProductDto;
use App\DTOs\AdminProductDto;
use Illuminate\Http\Request;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(Request $request)
    {
        $filters = [
            'category' => $request->query('category'),
            'search' => $request->query('search'),
            'min_price' => $request->query('min_price'),
            'max_price' => $request->query('max_price'),
            'is_active' => $request->query('is_active', true),
        ];

        $products = $this->productRepository->getFilteredProducts($filters);
        
        return $products->map(function ($product) {
            return new ProductDto($product);
        });
    }

    public function getProductById($id)
    {
        $product = $this->productRepository->findById($id);
        return $product ? new ProductDto($product) : null;
    }

    public function createProduct(array $data)
    {
        $product = $this->productRepository->create($data);
        return new AdminProductDto($product);
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->productRepository->update($id, $data);
        return $product ? new AdminProductDto($product) : null;
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }
}