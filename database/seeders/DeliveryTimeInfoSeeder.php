<?php

namespace Database\Seeders;

use App\Models\DeliveryTimeInfo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DeliveryTimeInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $start_time = Carbon::createFromTime(9, 0, 0);
        $end_time = Carbon::createFromTime(22, 0, 0);

        // Create a new DeliveryTimeInfo record
        DeliveryTimeInfo::create([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'before_message' => 'خدمة التوصيل متوفرة',
            'after_message' => 'من الممكن اختيار الطلب الآن والتوصيل صباحاً',
        ]);
    }
}
