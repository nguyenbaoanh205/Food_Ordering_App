<?php

namespace Database\Seeders;

use App\Models\Review as ModelsReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Review extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 30) as $index) {
            ModelsReview::create([
                'user_id' => rand(1, 10),
                'restaurant_id' => rand(1, 10),
                'rating' => fake()->randomFloat(1, 1, 5),
                'comment' => fake()->sentence,
            ]);
        }
    }

}
