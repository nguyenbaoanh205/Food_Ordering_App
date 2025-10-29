<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItemOption extends Model
{
    protected $fillable = ['cart_item_id', 'option_id'];

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function option()
    {
        return $this->belongsTo(FoodOption::class, 'option_id');
    }
}
