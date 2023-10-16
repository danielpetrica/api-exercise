<?php

namespace App\Jobs;

use Mockery\Exception;
use App\Models\Customer;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Log;

class Payment_intentCreatedJob extends GenericStripeJob {

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        try
        {
            $customer = Customer::find($this->object['customer']);
            if ($customer) {
                $payment_intent = $customer->payment_intents()->create($this->object);
                $payment_intent->json = $this->object;
                $payment_intent->save();
            } else {
                throw new Exception('Payment_intentCreatedJob: Customer missing');
            }
        } catch (Exception $e) {
            Log::error('Payment_intentCreatedJob failed', [
                "exception" => LogHelper::format_to_array($e),
                "object" => $this->object
            ]);
            // I throw the exception again so that the job is retried and marked as failed in the queue
            throw $e;
        }
    }
}
