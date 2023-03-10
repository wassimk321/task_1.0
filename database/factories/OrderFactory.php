<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
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
            'distance' => $this->faker->randomFloat(2, 1, 1000),
            'driver_id' => Driver::inRandomOrder()->first()->id,
            
        ];
    }
}
