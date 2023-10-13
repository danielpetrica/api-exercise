<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment_intent extends StripeBaseModel
{

    function customer (): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
