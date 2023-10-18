<?php

use App\Jobs\Payment_intentCreatedJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\assertDatabaseEmpty;

uses(RefreshDatabase::class );
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

$payment_intent =  [
    "id" => "pi_1Gt0Dk2eZvKYlo2CPe4OxqjT",
    "object" => "payment_intent",
    "amount" => 1000,
    "amount_capturable" => 0,
    "amount_details" => [
        "tip" => [
        ]
    ],
    "amount_received" => 0,
    "application" => null,
    "application_fee_amount" => null,
    "automatic_payment_methods" => null,
    "canceled_at" => null,
    "cancellation_reason" => null,
    "capture_method" => "automatic",
    "client_secret" => "pi_1Gt0Dk2eZvKYlo2CPe4OxqjT_secret_OxtiBvWSeXKh7OcvCTL24Enlx",
    "confirmation_method" => "automatic",
    "created" => 1591919648,
    "currency" => "usd",
    "customer" => $customer['id'],
    "description" => "Created by stripe.com/docs demo",
    "invoice" => null,
    "last_payment_error" => null,
    "latest_charge" => null,
    "livemode" => false,
    "metadata" => [
    ],
    "next_action" => null,
    "on_behalf_of" => null,
    "payment_method" => null,
    "payment_method_configuration_details" => null,
    "payment_method_options" => [
        "card" => [
            "installments" => null,
            "mandate_options" => null,
            "network" => null,
            "request_three_d_secure" => "automatic"
        ]
    ],
    "payment_method_types" => [
        "card"
    ],
    "processing" => null,
    "receipt_email" => null,
    "redaction" => null,
    "review" => null,
    "setup_future_usage" => null,
    "shipping" => null,
    "statement_descriptor" => null,
    "statement_descriptor_suffix" => null,
    "status" => "requires_payment_method",
    "transfer_data" => null,
    "transfer_group" => null
];

it('tests payment_intent.created event', function () use ($customer, $payment_intent) {
    // we avoid handling the job in real time
    Queue::fake();

    assertDatabaseEmpty('payment_intents');

    $initialTime = time();
    $response = $this->postJson(route('stripe.webhook'), [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "payment_intent.created",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $payment_intent
        ],
    ]);
    $finalTime = time();

    expect($response->status())
        ->toBe(201)
        ->and($finalTime - $initialTime)
        ->toBeLessThan(2);

    Queue::assertPushed(Payment_intentCreatedJob::class);
})->refreshDatabase();

it("checks job enqueue", function () use ($customer, $payment_intent) {
    Queue::fake();

    Queue::assertNothingPushed();

    $event =  [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "payment_intent.created",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $payment_intent
        ],
    ];

    assertDatabaseEmpty('customers');
    assertDatabaseEmpty('payment_intents');

    // add the customers so job execution works
    $customerModel = \App\Models\Customer::create($customer);

    $customerModel->json = $customer;
    $customerModel->save();

    \Pest\Laravel\assertDatabaseCount('customers', 1);

    Queue::push(Payment_intentCreatedJob::class, $event);

    Queue::assertPushed(Payment_intentCreatedJob::class);
})->refreshDatabase();

it("checks job processing", function () use ($customer, $payment_intent) {
    $event =  [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "payment_intent.created",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $payment_intent
        ],
    ];

    assertDatabaseEmpty('customers');
    assertDatabaseEmpty('payment_intents');

    // add the customers so job execution works
    $customerModel = \App\Models\Customer::create($customer);

    $customerModel->json = $customer;
    $customerModel->save();

    \Pest\Laravel\assertDatabaseCount('customers', 1);

    $job = new Payment_intentCreatedJob($event);

    $job->handle();
})->refreshDatabase();

it("checks job processing that must fail",
function () use ($customer, $payment_intent) {
    $event =  [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "payment_intent.created",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $payment_intent
        ],
    ];

    assertDatabaseEmpty('customers');
    assertDatabaseEmpty('payment_intents');

    $job = new Payment_intentCreatedJob($event);
    // it must trow exception for missing customer
    $job->handle();
})->throws(Exception::class)->refreshDatabase();
