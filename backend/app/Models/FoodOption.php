<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodOption extends Model
{
    protected $table = 'food_options';
    protected $fillable = [
        'food_id',
        'name',
        'extra_price',
        'type',
    ];
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    // Liên kết đến cart và order qua bảng trung gian
    public function cartItemOptions()
    {
        return $this->hasMany(CartItemOption::class, 'option_id');
    }

    public function orderItemOptions()
    {
        return $this->hasMany(OrderItemOption::class, 'option_id');
    }
}
