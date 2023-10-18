<?php

namespace App\Jobs;

use Exception;
use App\Models\Account;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountUpdatedJob extends GenericStripeJob implements ShouldQueue
{
    /**
     * Execute the job
     * @throws Exception
     */
    public function handle(): void
    {
        try
        {
            $account =  Account::query()
                ->where( 'id', '=', $this->object['id'])
                ->firstOrFail();

            $account->update($this->object);
            $account->json = $this->object;
            $account->save();

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
