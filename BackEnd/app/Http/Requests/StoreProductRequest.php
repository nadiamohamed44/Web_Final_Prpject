<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // التحكم بالصلاحيات بيكون في middleware
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'preparation_time' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'price.required' => 'السعر مطلوب',
            'price.min' => 'السعر يجب أن يكون أكبر من 0',
            'discount_price.lt' => 'سعر الخصم يجب أن يكون أقل من السعر الأصلي',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.max' => 'حجم الصورة يجب أن لا يتعدى 2MB',
            'category_id.exists' => 'الفئة المحددة غير موجودة'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('name') && !$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->name) . '-' . Str::random(5)
            ]);
        }
    }
}