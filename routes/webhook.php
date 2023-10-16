<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

/**
 * File for webhook routes published under /api/webhook
 */

/*
 * webhook events list: https://stripe.com/docs/api/events/types
 * As stripe lets you specify which event to receive on each endpoint we can either have single endpoints for each event or manage them all in one place
 * For now we will manage them all in one place.
 */
Route::post('/stripe', WebhookController::class)->name('stripe.webhook');
