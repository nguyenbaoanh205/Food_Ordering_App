<?php

namespace Database\Seeders;

use App\Models\Order as ModelsOrder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Order extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $userID= User::pluck('id')->toArray();
        foreach (range(1, 20) as $index) {
            ModelsOrder::create([
                'user_id' => fake()->randomElement($userID) , // Giả sử có 10 người dùng
                'restaurant_id' => rand(1, 10),
                'total_amount' => fake()->randomFloat(2, 10, 500),
                'status' => fake()->randomElement(['Pending', 'Completed', 'Cancelled']),
                'delivery_address' => fake()->address,
            ]);
        }
    }

}
