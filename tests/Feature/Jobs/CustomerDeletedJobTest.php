<?php

use App\Jobs\CustomerDeletedJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use function Pest\Laravel\expectsJobs;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class );

it('checks Customer deleted job', function () {
    Queue::fake();
    // let's create a customer
    $customer =  [
        "id" => "cus_9s6XKzkNRiz8i3",
        "object" => "customer",
        "address" => null,
        "balance" => -500,
        "created" => 1483565364,
        "currency" => "usd",
        "default_source" => "card_1NZex82eZvKYlo2CZR21ocY1",
        "delinquent" => false,
        "description" => "Casetabs Organization",
        "discount" => null,
        "email" => "test@test.com",
        "invoice_prefix" => "28278FC",
        "invoice_settings" => [
            "custom_fields" => null,
            "default_payment_method" => null,
            "footer" => null,
            "rendering_options" => null
        ],
        "livemode" => false,
        "metadata" => [
            "order_id" => "6735"
        ],
        "name" => null,
        "next_invoice_sequence" => 194,
        "phone" => null,
        "preferred_locales" => [
        ],
        "shipping" => null,
        "tax_exempt" => "none",
        "test_clock" => null
    ];
    $customerModel = \App\Models\Customer::create($customer);
    $customerModel->json = $customer;
    $customerModel->save();

    $customer = \App\Models\Customer::first();
    expect($customer->id)->toBe($customer['id']);

    $initialTime = time();

    // we receive the customer delete webhook
    $response = $this->postJson(route('stripe.webhook'), [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "customer.deleted",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => [
                'id' => $customer->id,
                "object" => "customer",
            ]
        ],
    ]);

    $finalTime = time();

    expect($response->status())
        ->toBe(201)
        ->and($finalTime - $initialTime)
        ->toBeLessThan(2);

    // successful response from webhook
    // stripe needs a response within 2 seconds, better if less

})->refreshDatabase();

it('It tests job enqueue', function() {
    Queue::fake();

    Queue::assertNothingPushed();

    $event = [
        'id' => 'ev_01',
        'data' => [
            'object' => [
                'id' => "cus_9s6XKzkNRiz8i3",
                "object" => "customer",
            ]
        ]];
    $job = Queue::push(CustomerDeletedJob::class, $event);

    Queue::assertPushed(CustomerDeletedJob::class);

} )->refreshDatabase();

it("it tests a job execution that should fail", function () {
    $event = ['id' => 'ev_01', 'data' => [
                        'object' => [
                            'id' => "cus_9s6XKzkNRiz8i3",
                            "object" => "customer",
                        ]
                    ]];
    Queue::fake();

    $job = new CustomerDeletedJob($event);

    $job->handle();
})->throws(Exception::class)->refreshDatabase();
