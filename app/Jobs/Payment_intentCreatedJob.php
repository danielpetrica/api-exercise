<?php

namespace App\Jobs;

use App\Models\Payment_intent;
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
            try {
                $customer = Customer::query()->where(
                        'id',
                        '=',
                        $this->object['customer'])
                    ->firstOrFail();
            } catch (\Exception $e) {
                throw new Exception('Payment_intentCreatedJob: Customer missing');
            }

            $obj = $this->object;

            $customer->unsetRelation('payment_intents');

//            $customer->payment_intents()->create($obj);

            $paymentIntentModel = Payment_intent::create($obj);
            $paymentIntentModel->json = $obj;
            $paymentIntentModel->save();

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
