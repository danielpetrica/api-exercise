<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

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
}
