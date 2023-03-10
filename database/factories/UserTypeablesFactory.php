<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTypeablesFactory extends Factory
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
            'user_id' => User::inRandomOrder()->first()->id,
            'user_typeable_id' => Driver::inRandomOrder()->first()->id,
            'user_typeable_type' => 'App\Models\Driver',
        ];
    }
}
