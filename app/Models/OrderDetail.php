<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'from_time',
        'to_time',
        'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
