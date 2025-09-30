<?php

namespace Database\Seeders;

use App\Models\OrderHistory as ModelsOrderHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderHistory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 20) as $index) {
            ModelsOrderHistory::create([
                'order_id' => rand(1, 20),
                'status' => fake()->randomElement(['Pending', 'Completed', 'Cancelled']),
            ]);
        }
    }

}
