<?php

use App\Jobs\CustomerCreatedJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
uses(RefreshDatabase::class );
// I reuse the customer
$customer =  [
    "id" => "cus_9s6XKzkNRiz8i3",
    "object" => "customer",
    "address" => [
        "test" => "test"
    ],
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
    "shipping" => [
        "test" => "test"
    ],
    "tax_exempt" => "none",
    "test_clock" => null
];
it('tests the webhook', function () use ($customer) {
    Queue::fake();

    \Pest\Laravel\assertDatabaseEmpty('customers');

    $initialTime = time();
    $response = $this->postJson(route('stripe.webhook'), [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "customer.created",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $customer
        ],
    ]);
    $finalTime = time();

    expect($response->status())
        ->toBe(201)
        ->and($finalTime - $initialTime)
        ->toBeLessThan(2);

    Queue::assertPushed(CustomerCreatedJob::class);

})->refreshDatabase();

it("tests job enqueue",
 function () use ($customer) {
     Queue::fake();

     Queue::assertNothingPushed();

     $event = [
         'object'    => 'event',
         "id"        => 'ev_01',
         "type"      => "customer.created",
         "api_version" => "2019-12-03",
         "created" => 1599750000,
         'data' => [
             'object' => $customer
         ],
     ];

     $job = Queue::push(CustomerCreatedJob::class, $event);

     Queue::assertPushed(CustomerCreatedJob::class);
 }
)->refreshDatabase();

it("tests job processing",
 function () use ($customer) {

     $event = [
         'object'    => 'event',
         "id"        => 'ev_01',
         "type"      => "customer.created",
         "api_version" => "2019-12-03",
         "created" => 1599750000,
         'data' => [
             'object' => $customer
         ],
     ];

     \Pest\Laravel\assertDatabaseCount('customers', 0);
     $job =  new CustomerCreatedJob($event);

     $job->handle();
     \Pest\Laravel\assertDatabaseCount('customers', 1);

     $model = \App\Models\Customer::query()->where('id', '=', $customer['id'])->firstOrFail();

     expect($model->address)->toBeArray();
     expect($model->shipping)->toBeArray();
     expect($model->payment_intents)->toBeEmpty();
 }
)->refreshDatabase();

it("tests a job that should fail",
   function () use ($customer) {

       $customerModel = \App\Models\Customer::create($customer);
       $customerModel->json = $customer;
       $customerModel->save();

       \Pest\Laravel\assertDatabaseCount('customers', 1);

       $event = [
           'object'    => 'event',
           "id"        => 'ev_01',
           "type"      => "customer.created",
           "api_version" => "2019-12-03",
           "created" => 1599750000,
           'data' => [
               'object' => $customer
           ],
       ];

       $job = new CustomerCreatedJob($event);

       $job->handle();
   }
)->throws(Exception::class)->refreshDatabase();
