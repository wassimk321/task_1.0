<?php

namespace Database\Seeders;

use App\Models\DeliveryTimeInfo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call(UsersSeeder::class);
         $this->call(GenreSeeder::class);
         $this->call(MovieSeeder::class);
    }
}
