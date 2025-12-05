<?php

namespace App\DTOs;

class ProductDto
{
    public $id;
    public $name;
    public $slug;
    public $description;
    public $price;
    public $sale_price;
    public $category_id;
    public $category_name;
    public $is_active;
    public $is_featured;
    public $size;
    public $images;
    public $created_at;
    
    public function __construct($product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->sale_price = $product->sale_price;
        $this->category_id = $product->category_id;
        $this->category_name = $product->category->name ?? null;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->size = $product->size;
        $this->images = $product->images;
        $this->created_at = $product->created_at;
    }
}