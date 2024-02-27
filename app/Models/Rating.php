<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = "ratings";

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating'
    ];

    protected $casts = [
        'user_id' => 'string',
        'movie_id' => 'string',
        'rating' => 'integer',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
