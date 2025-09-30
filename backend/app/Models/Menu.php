<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['restaurant_id', 'item_name', 'description', 'price', 'category', 'is_available'];
}
