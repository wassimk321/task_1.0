<?php

namespace Database\Seeders;

use App\Models\UserTypeables;
use Illuminate\Database\Seeder;

class UserTypeablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\UserTypeables::factory()->count(10)->create();
    }
}
