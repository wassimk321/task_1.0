<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id',
        'distance',
    ];

    public function getDistanceAttribute($value)
    {
        return $value / 1000;
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
