<?php

namespace Database\Seeders;

use App\Models\Restaurant as ModelsRestaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Restaurant extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            ModelsRestaurant::create([
                'name' => fake()->company,
                'address' => fake()->address,
                'phone' => fake()->phoneNumber,
                'rating' => fake()->randomFloat(2, 1, 5),
                'description' => fake()->paragraph,
                'opening_hours' => fake()->time() . ' - ' . fake()->time(),
            ]);
        }
    }

}
