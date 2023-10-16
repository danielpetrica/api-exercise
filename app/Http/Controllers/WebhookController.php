<?php

namespace App\Http\Controllers;

use App\Jobs\GenericStripeJob;
use App\Jobs\AccountUpdatedJob;
use App\Jobs\CustomerCreatedJob;
use App\Jobs\CustomerDeletedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\Payment_intentCreatedJob;

class WebhookController extends Controller
{
    /**
     * Handle the incoming request. Single responsibility function for the class
     */
    public function __invoke(Request $request)
    {
        // Get the type of event sent from stripe
        $body = $request->json()->all();

        if (!isset($body["type"])) {
            Log::error('Missing type', ["received_body" => $body]);

            return response('Missing type', 400);
        }
        $type = $body["type"];

        // Handle the event
        match ($type) {
            //'account.updated' => AccountUpdatedJob::dispatch($body)->delay(now()->addSeconds(5)),
            // Someone you pay out to from stripe
            'account.updated' => AccountUpdatedJob::dispatch($body),
            // Someone you receive a payment from
            'customer.created' => CustomerCreatedJob::dispatch($body),
            'customer.deleted' => CustomerDeletedJob::dispatch($body),
            'payment_intent.created' => Payment_intentCreatedJob::dispatch($body)->delay(now()->addSeconds(10)),

            default => GenericStripeJob::dispatch($body),
        };


        return response(null, 201);

    }
}
