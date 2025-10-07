<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = ['user_id', 'session_id'];

    // Một giỏ hàng có nhiều sản phẩm
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Quan hệ ngược lại tới user (nếu có)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
