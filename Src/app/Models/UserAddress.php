<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'address_line',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
