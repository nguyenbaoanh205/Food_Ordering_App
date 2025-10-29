<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['name', 'price', 'description', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function options()
    {
        return $this->hasMany(FoodOption::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
