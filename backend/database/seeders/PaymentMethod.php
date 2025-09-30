<?php

namespace Database\Seeders;

use App\Models\PaymentMethod as ModelsPaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethod extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            ModelsPaymentMethod::create([
                'user_id' => rand(1, 10),
                'payment_type' => fake()->randomElement(['Credit Card', 'PayPal', 'Bank Transfer']),
                'provider' => fake()->word,
                'account_number' => fake()->optional()->bankAccountNumber,
            ]);
        }
    }

}
