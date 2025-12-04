<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    // ده الحل السريع جدًا واللي شغال 100%
    protected $guarded = [];
    
    // لو عايزة تحطي الحقول بالاسم بدل ما تسيبي الكل مفتوح، استخدمي السطر ده بس:
    // protected $fillable = ['name', 'price', 'category_id', 'description', 'image', 'is_available'];
}