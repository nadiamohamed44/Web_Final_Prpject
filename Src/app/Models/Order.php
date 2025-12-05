<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

   

    protected $casts = [
        'total' => 'decimal:2'
    ];

   // في app/Models/Order.php
protected $fillable = [
    'user_id',
    'total',
    'total_amount',
    'status',
    'payment_method',
    'payment_status',
    'shipping_address',
    'address',        // ⬅️ هذا السطر مهم جداً
    'phone',
    'notes'
  ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


}
