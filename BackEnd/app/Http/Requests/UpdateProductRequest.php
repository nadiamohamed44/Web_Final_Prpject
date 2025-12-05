<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0.01',
            'discount_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'preparation_time' => 'nullable|integer|min:1'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('name')) {
            $this->merge([
                'slug' => Str::slug($this->name) . '-' . Str::random(5)
            ]);
        }
        
        // تأكد أن discount_price أقل من price
        if ($this->has('discount_price') && $this->has('price')) {
            $this->merge([
                'discount_price' => min($this->discount_price, $this->price - 0.01)
            ]);
        }
    }
}