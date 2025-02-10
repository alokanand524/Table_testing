<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class people_trans extends Model
{
    use HasFactory;

    protected $fillable = ['person_id', 'order_no', 'payment_trans', 'amount', 'status'];

}
