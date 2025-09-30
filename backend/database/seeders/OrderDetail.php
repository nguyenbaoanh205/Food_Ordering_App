<?php

namespace Database\Seeders;

use App\Models\OrderDetail as ModelsOrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetail extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 50) as $index) {
            ModelsOrderDetail::create([
                'order_id' => rand(1, 20), // Giả sử có 20 đơn hàng
                'menu_id' => rand(1, 30), // Giả sử có 30 món ăn
                'quantity' => rand(1, 5),
                'price' => fake()->randomFloat(2, 5, 100),
            ]);
        }
    }


}
