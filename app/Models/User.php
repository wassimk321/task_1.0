<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,SoftDeletes;

    protected $table = "users";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
    ];




    protected $hidden = [
        'password',
        'deleted_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id')->select(['id', 'name']);
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getUserNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
