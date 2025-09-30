<?php

namespace Database\Seeders;

use App\Models\Menu as ModelsMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Menu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 30) as $index) {
            ModelsMenu::create([
                'restaurant_id' => rand(1, 10), // Giả sử có 10 nhà hàng
                'item_name' => fake()->word,
                'description' => fake()->sentence,
                'price' => fake()->randomFloat(2, 5, 100),
                'category' => fake()->word,
                'is_available' => fake()->boolean,
            ]);
        }
    }

}
