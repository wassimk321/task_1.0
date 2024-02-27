<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = "genres";

    protected $fillable = [
        'name'
    ];

    protected $casts = [
       'name' => 'string',

    ];

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }


}
