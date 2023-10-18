<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends StripeBaseModel
{

    protected $fillable = [
        'internal_id',
        'id',
        'json',
        'email',
        'created',
        'address',
        'shipping'
    ];

    protected $casts = [
        'address' => 'array',
        'shipping' => 'array'
    ];

    function payment_intents (): HasMany
    {
        return $this->hasMany(Payment_intent::class, 'id','customer');
    }
}
