<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'receiver_name', 'receiver_phone', 'receiver_address', 'total', 'status', 'payment_method', 'payment_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }
}
