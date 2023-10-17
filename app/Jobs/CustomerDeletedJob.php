<?php

namespace App\Jobs;

use Exception;
use App\Models\Customer;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerDeletedJob extends GenericStripeJob implements ShouldQueue
{

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {

        try {
            $customer = Customer::query()->where('id', $this->object['id'])->firstOrFail();

            $customer->delete();
            // @todo: probably related entities should be deleted too
        } catch ( Exception $e ) {
            Log::error('CustomerDeletedJob failed', [
                "exception" => LogHelper::format_to_array($e),
                "object" => $this->object
            ]);
            // I throw the exception again so that the job is retried and marked as failed in the queue
            throw $e;
        }
    }
}
