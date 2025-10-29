<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemOption extends Model
{
    protected $fillable = ['order_detail_id', 'option_id'];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function option()
    {
        return $this->belongsTo(FoodOption::class, 'option_id');
    }
}
