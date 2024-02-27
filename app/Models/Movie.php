<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = "movies";

    protected $fillable = [
        'title',
        'year'
    ];

    protected $casts = [
       'title' => 'string',
       'year' => 'integer',

    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
