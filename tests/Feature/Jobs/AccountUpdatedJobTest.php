<?php

use App\Jobs\AccountUpdatedJob;
use App\Models\Account;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertModelExists;


$parsedArray = [
    "id" => "acct_1032D82eZvKYlo2C",
    "object" => "account",
    "business_profile" => [
        "mcc" => null,
        "name" => "Stripe.com",
        "product_description" => null,
        "support_address" => null,
        "support_email" => null,
        "support_phone" => null,
        "support_url" => null,
        "url" => null
    ],
    "capabilities" => [
        "card_payments" => "active",
        "transfers" => "active"
    ],
    "charges_enabled" => false,
    "controller" => [
        "type" => "application",
        "is_controller" => true
    ],
    "country" => "US",
    "created" => 1385798567,
    "default_currency" => "usd",
    "details_submitted" => false,
    "email" => "site@stripe.com",
    "external_accounts" => [
        "object" => "list",
        "data" => [
        ],
        "has_more" => false,
        "url" => "/v1/accounts/acct_1032D82eZvKYlo2C/external_accounts"
    ],
    "future_requirements" => [
        "alternatives" => [
        ],
        "current_deadline" => null,
        "currently_due" => [
        ],
        "disabled_reason" => null,
        "errors" => [
        ],
        "eventually_due" => [
        ],
        "past_due" => [
        ],
        "pending_verification" => [
        ]
    ],
    "metadata" => [
    ],
    "payouts_enabled" => false,
    "requirements" => [
        "alternatives" => [
        ],
        "current_deadline" => null,
        "currently_due" => [
            "business_profile.mcc",
            "business_profile.product_description",
            "business_profile.support_phone",
            "business_profile.url",
            "business_type",
            "external_account",
            "person_8UayFKIMRJklog.first_name",
            "person_8UayFKIMRJklog.last_name",
            "tos_acceptance.date",
            "tos_acceptance.ip"
        ],
        "disabled_reason" => "requirements.past_due",
        "errors" => [
        ],
        "eventually_due" => [
            "business_profile.mcc",
            "business_profile.product_description",
            "business_profile.support_phone",
            "business_profile.url",
            "business_type",
            "external_account",
            "person_8UayFKIMRJklog.first_name",
            "person_8UayFKIMRJklog.last_name",
            "tos_acceptance.date",
            "tos_acceptance.ip"
        ],
        "past_due" => [
            "business_profile.mcc",
            "business_profile.product_description",
            "business_profile.support_phone",
            "business_profile.url",
            "business_type",
            "external_account",
            "person_8UayFKIMRJklog.first_name",
            "person_8UayFKIMRJklog.last_name",
            "tos_acceptance.date",
            "tos_acceptance.ip"
        ],
        "pending_verification" => [
        ]
    ],
    "settings" => [
        "bacs_debit_payments" => [
        ],
        "branding" => [
            "icon" => null,
            "logo" => null,
            "primary_color" => null,
            "secondary_color" => null
        ],
        "card_issuing" => [
            "tos_acceptance" => [
                "date" => null,
                "ip" => null
            ]
        ],
        "card_payments" => [
            "decline_on" => [
                "avs_failure" => true,
                "cvc_failure" => false
            ],
            "statement_descriptor_prefix" => null,
            "statement_descriptor_prefix_kanji" => null,
            "statement_descriptor_prefix_kana" => null
        ],
        "dashboard" => [
            "display_name" => "Stripe.com",
            "timezone" => "US/Pacific"
        ],
        "payments" => [
            "statement_descriptor" => null,
            "statement_descriptor_kana" => null,
            "statement_descriptor_kanji" => null
        ],
        "payouts" => [
            "debit_negative_balances" => true,
            "schedule" => [
                "delay_days" => 7,
                "interval" => "daily"
            ],
            "statement_descriptor" => null
        ],
        "sepa_debit_payments" => [
        ]
    ],
    "tos_acceptance" => [
        "date" => null,
        "ip" => null,
        "user_agent" => null
    ],
    "type" => "standard"
];

uses(RefreshDatabase::class );

it('check webhook', function () use ($parsedArray) {
    // we avoid handling the job in real time
    Queue::fake();

    assertDatabaseEmpty('accounts');

    $parsedArray = [
        "id" => "acct_1032D82eZvKYlo2C",
        "object" => "account",
        "business_profile" => [
            "mcc" => null,
            "name" => "Stripe.com",
            "product_description" => null,
            "support_address" => null,
            "support_email" => null,
            "support_phone" => null,
            "support_url" => null,
            "url" => null
        ],
        "capabilities" => [
            "card_payments" => "active",
            "transfers" => "active"
        ],
        "charges_enabled" => false,
        "controller" => [
            "type" => "application",
            "is_controller" => true
        ],
        "country" => "US",
        "created" => 1385798567,
        "default_currency" => "usd",
        "details_submitted" => false,
        "email" => "site@stripe.com",
        "external_accounts" => [
            "object" => "list",
            "data" => [
            ],
            "has_more" => false,
            "url" => "/v1/accounts/acct_1032D82eZvKYlo2C/external_accounts"
        ],
        "future_requirements" => [
            "alternatives" => [
            ],
            "current_deadline" => null,
            "currently_due" => [
            ],
            "disabled_reason" => null,
            "errors" => [
            ],
            "eventually_due" => [
            ],
            "past_due" => [
            ],
            "pending_verification" => [
            ]
        ],
        "metadata" => [
        ],
        "payouts_enabled" => false,
        "requirements" => [
            "alternatives" => [
            ],
            "current_deadline" => null,
            "currently_due" => [
                "business_profile.mcc",
                "business_profile.product_description",
                "business_profile.support_phone",
                "business_profile.url",
                "business_type",
                "external_account",
                "person_8UayFKIMRJklog.first_name",
                "person_8UayFKIMRJklog.last_name",
                "tos_acceptance.date",
                "tos_acceptance.ip"
            ],
            "disabled_reason" => "requirements.past_due",
            "errors" => [
            ],
            "eventually_due" => [
                "business_profile.mcc",
                "business_profile.product_description",
                "business_profile.support_phone",
                "business_profile.url",
                "business_type",
                "external_account",
                "person_8UayFKIMRJklog.first_name",
                "person_8UayFKIMRJklog.last_name",
                "tos_acceptance.date",
                "tos_acceptance.ip"
            ],
            "past_due" => [
                "business_profile.mcc",
                "business_profile.product_description",
                "business_profile.support_phone",
                "business_profile.url",
                "business_type",
                "external_account",
                "person_8UayFKIMRJklog.first_name",
                "person_8UayFKIMRJklog.last_name",
                "tos_acceptance.date",
                "tos_acceptance.ip"
            ],
            "pending_verification" => [
            ]
        ],
        "settings" => [
            "bacs_debit_payments" => [
            ],
            "branding" => [
                "icon" => null,
                "logo" => null,
                "primary_color" => null,
                "secondary_color" => null
            ],
            "card_issuing" => [
                "tos_acceptance" => [
                    "date" => null,
                    "ip" => null
                ]
            ],
            "card_payments" => [
                "decline_on" => [
                    "avs_failure" => true,
                    "cvc_failure" => false
                ],
                "statement_descriptor_prefix" => null,
                "statement_descriptor_prefix_kanji" => null,
                "statement_descriptor_prefix_kana" => null
            ],
            "dashboard" => [
                "display_name" => "Stripe.com",
                "timezone" => "US/Pacific"
            ],
            "payments" => [
                "statement_descriptor" => null,
                "statement_descriptor_kana" => null,
                "statement_descriptor_kanji" => null
            ],
            "payouts" => [
                "debit_negative_balances" => true,
                "schedule" => [
                    "delay_days" => 7,
                    "interval" => "daily"
                ],
                "statement_descriptor" => null
            ],
            "sepa_debit_payments" => [
            ]
        ],
        "tos_acceptance" => [
            "date" => null,
            "ip" => null,
            "user_agent" => null
        ],
        "type" => "standard"
    ];

    $account = Account::create($parsedArray);
    $account->json = $parsedArray;
    $account->save();

    assertModelExists($account);

    assertDatabaseCount('accounts', 1);

    $initialTime = time();
    $response = $this->postJson(route('stripe.webhook'), [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "account.updated",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $parsedArray
        ],
    ]);
    $finalTime = time();

    expect($response->status())
        ->toBe(201)
        ->and($finalTime - $initialTime)
        ->toBeLessThan(2);

    Queue::assertPushed(AccountUpdatedJob::class);
})->refreshDatabase();

it("check job enqueue", function () use ($parsedArray) {
    Queue::fake();

    Queue::assertNothingPushed();

    $event =  [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "account.updated",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $parsedArray
        ],
    ];

    $job = Queue::push(AccountUpdatedJob::class, $event);

    Queue::assertPushed(AccountUpdatedJob::class);
})->refreshDatabase();

it("check job processing", function () use ($parsedArray) {
    assertDatabaseEmpty('accounts' );
    $account = Account::create($parsedArray);
    //    $account->json = $parsedArray;
    $account->save();

    $event =  [
        'object'    => 'event',
        "id"        => 'ev_01',
        "type"      => "account.updated",
        "api_version" => "2019-12-03",
        "created" => 1599750000,
        'data' => [
            'object' => $parsedArray
        ],
    ];

    assertDatabaseCount('accounts' , 1);
    $job = new AccountUpdatedJob($event);

    assertDatabaseCount('accounts' , 1);
    $job->handle();
    $account =  Account::query()
        ->where( 'id', '=', $parsedArray['id'])
        ->firstOrFail();

    expect($account->json)->toBeArray();
})->refreshDatabase();

it(" tests a job execution that should fail",
    function () use ($parsedArray) {
        $event =  [
            'object'    => 'event',
            "id"        => 'ev_01',
            "type"      => "account.updated",
            "api_version" => "2019-12-03",
            "created" => 1599750000,
            'data' => [
                'object' => $parsedArray
            ],
        ];
        Queue::fake();

        $job = new AccountUpdatedJob($event);

        $job->handle();
    }
)->throws(Exception::class)->refreshDatabase();
