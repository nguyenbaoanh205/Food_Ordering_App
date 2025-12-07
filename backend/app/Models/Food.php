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

    public function getImageAttribute($value)
    {
        // Nếu đã là URL đầy đủ rồi thì trả về luôn (tránh lỗi khi update)
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Nếu không, tự động tạo URL đầy đủ
        return $value ? url($value) : null;
    }
}
