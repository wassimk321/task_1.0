<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'order_id' => Order::inRandomOrder()->first()->id,
            'from_time' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'to_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'date' => $this->faker->date(),
        ];
    }
}
