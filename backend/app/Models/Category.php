<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name'];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}
