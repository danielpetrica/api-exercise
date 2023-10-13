<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class StripeBaseModel extends Model
{
    use SoftDeletes, HasTimestamps;

    protected $primaryKey = "internal_id";

    protected $casts = [
        'json' => 'array',
    ];
}
