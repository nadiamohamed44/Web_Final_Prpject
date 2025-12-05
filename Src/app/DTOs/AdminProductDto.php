<?php

namespace App\DTOs;

class AdminProductDto
{
    public $id;
    public $name;
    public $slug;
    public $description;
    public $price;
    public $sale_price;
    public $stock_quantity;
    public $sku;
    public $category_id;
    public $is_active;
    public $is_featured;
    public $size;
    public $images;
    public $weight;
    public $dimensions;
    public $created_at;
    public $updated_at;
    
    public function __construct($product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->sale_price = $product->sale_price;
        $this->stock_quantity = $product->stock_quantity;
        $this->sku = $product->sku;
        $this->category_id = $product->category_id;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->size = $product->size;
        $this->images = $product->images;
        $this->weight = $product->weight;
        $this->dimensions = $product->dimensions;
        $this->created_at = $product->created_at;
        $this->updated_at = $product->updated_at;
    }
}