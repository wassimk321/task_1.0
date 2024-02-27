<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'id'    => 1,
            'first_name'  => 'Admin',
            'last_name'  => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('1234567890'),
            'phone'    => '0938385476',
        ]);
    }
}
