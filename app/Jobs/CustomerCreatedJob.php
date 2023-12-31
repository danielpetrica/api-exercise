<?php

namespace App\Jobs;

use Exception;
use App\Models\Customer;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerCreatedJob extends GenericStripeJob implements ShouldQueue
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try
        {
            $customer = Customer::create($this->object);
            $customer->json = $this->object;
            $customer->save();
        } catch ( Exception $e ) {
            Log::error('AccountUpdatedJob failed', [
                "exception" => LogHelper::format_to_array($e),
                "object" => $this->object
            ]);
            // I throw the exception again so that the job is retried and marked as failed in the queue
            throw $e;
        }

    }
}
