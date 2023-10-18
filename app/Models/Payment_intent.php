<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment_intent extends StripeBaseModel
{
    protected $table = 'payment_intents';
    protected $fillable = [
        'id',
        'json',
        'customer'
    ];

    function customer (): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }
}
