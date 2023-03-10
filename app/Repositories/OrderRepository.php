<?php

namespace App\Repositories;

use App\Models\Driver;
use App\Models\Order;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
  
    public function all()
    {
        return $this->order->all();
    }
    public function drivers()
    {
        return Driver::all();
    }

    public function report($validated){
        $driver = Driver::findOrFail($validated['driver_id']);
        $orders = Order::whereHas('driver', function ($query) use ($driver, $validated) {
            $query
                ->where('id', $driver->id);
        })
            ->with(['driver', 'orderDetails' => function ($query) use ($validated) {
                $query
                    ->whereRaw("DATE(from_time) BETWEEN '{$validated['date_from']}' AND '{$validated['date_to']}'")
                    ->whereRaw("DATE(to_time) BETWEEN '{$validated['date_from']}' AND '{$validated['date_to']}'");
                // ->whereRaw("TIME(from_time) BETWEEN '{$validated['time_from']}' AND '{$validated['time_to']}'")
                // ->whereRaw("TIME(to_time) BETWEEN '{$validated['time_from']}' AND '{$validated['time_to']}'");

            }])
            ->whereHas('orderDetails')
            ->get();
        $orders = $orders->reject(function ($order) {
            return $order->orderDetails->isEmpty();
        });
        $totalDistance = 0;
        $totalHours = 0;

        foreach ($orders as $order) {
            $totalDistance += $order->distance;

            foreach ($order->orderDetails as $orderDetail) {
                $fromTime = strtotime($orderDetail->from_time);
                $toTime = strtotime($orderDetail->to_time);
                $timeDiff = $toTime - $fromTime;
                $hours = $timeDiff / 3600; // 1 hour = 3600 seconds
                $totalHours += $hours;
            }
        }

        return [
            'driver' => $driver,
            'orders' => $orders,
            'totalDistance' => $totalDistance,
            'totalHours' => $totalHours
        ];
    }

   
}
