<?php

namespace App\Http\Controllers;

use App\Jobs\AccountUpdatedJob;
use App\Jobs\CustomerCreatedJob;
use App\Jobs\CustomerDeletedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle the incoming request. Single responsibility function for the class
     */
    public function __invoke(Request $request)
    {
        // Get the type of event sent from stripe
        $body = $request->json();
        if (!isset($body["type"])) {
            Log::error('Missing type', ["received_body" => $body]);

            return response('Missing type', 400);
        }
        $type = $body["type"];

        // Handle the event
        match ($type) {
            //'account.updated' => AccountUpdatedJob::dispatch($body)->delay(now()->addSeconds(5)),
          'account.updated' => AccountUpdatedJob::dispatch($body), // not the customer, it's external account like card and bank account
          'customer.created' => CustomerCreatedJob::dispatch($body),
          'customer.deleted' => CustomerDeletedJob::dispatch($body),

        };

    }
}
