<?php

namespace App\Models;


class Account extends StripeBaseModel
{
    protected $fillable = [
       'id',
       'json',
    ];



}
