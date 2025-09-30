<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'restaurant_id', 'order_date', 'total_amount', 'status', 'delivery_address'];
}
