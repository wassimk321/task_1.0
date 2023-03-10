<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;


class OrderController extends Controller
{
    //
    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        # code...
        $orders = $this->repository->all();
        $drivers = $this->repository->drivers();
        return view('admin.orders', compact('orders', 'drivers'));
    }
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i',
            'driver_id' => 'required|exists:drivers,id'
        ]);

        $data = $this->repository->report($validated);

        return view('admin.driver_report', compact('data'));
    }
}
