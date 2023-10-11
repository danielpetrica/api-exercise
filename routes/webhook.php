<?php
use Illuminate\Support\Facades\Route;

/**
 * File for webhook routes published under /api/webhook
 */

/*
 * webhook events list: https://stripe.com/docs/api/events/types
 * As stripe lets you specify which event to receive on each endpoint we can either have single endpoints for each event or manage them all in one place
 * For now we will manage them all in one place.
 */
Route::get('/stripe', \App\Http\Controllers\WebhookController::class);
