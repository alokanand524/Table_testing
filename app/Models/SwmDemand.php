<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwmDemand extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumer_id',
        'total_tax',
        'payment_from',
        'payment_to',
        'paid_status',
        'last_payment_id',
        'user_id',
        'stampdate',
        'demand_date',
        'is_deactivate',
    ];
}
