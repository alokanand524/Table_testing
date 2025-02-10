<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consumer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'mobile'];

    /**
     * Get all transactions for the consumer.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(ConTrans::class);
    }
}
