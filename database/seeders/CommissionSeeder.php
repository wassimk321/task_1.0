<?php

namespace Database\Seeders;

use App\Models\Commission;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Commission::create(
            [
                'name' => 'percentage'
            ],
            [
                'name' => 'fixed'
            ],
        );
    }
}
