<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'pan',
        'aadhar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function searchByUserDetails($field, $value){

        // $fileds = ['email', 'mobile', 'pan', 'aadhar'];

        // if(!in_array($field, $fileds)){
        //     throw new Exception('Search Fiels in Invalid');
        // }

        return self::select("*")
        ->where($field, $value)
        ->first();

    }
}
