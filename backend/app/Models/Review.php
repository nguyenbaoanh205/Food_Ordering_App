<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['user_id', 'order_id', 'food_id', 'rating', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
