<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConTrans extends Model
{
    use HasFactory;

    protected $fillable = ['consumer_id', 'order_no', 'transaction_no', 'amount', 'status'];

    /**
     * Get the consumer associated with the transaction.
     */
    public function consumer(): BelongsTo
    {
        return $this->belongsTo(Consumer::class);
    }
}
