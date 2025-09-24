<?php

return [
    'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
    'secret_key' => env('STRIPE_SECRET_KEY'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    
    'plans' => [
        '3_months' => [
            'name' => '3 mois Premium',
            'price' => 4500, // 45€ en centimes
            'duration_months' => 3,
        ],
        '6_months' => [
            'name' => '6 mois Premium',
            'price' => 6600, // 66€ en centimes
            'duration_months' => 6,
        ],
        '12_months' => [
            'name' => '12 mois Premium',
            'price' => 9600, // 96€ en centimes
            'duration_months' => 12,
        ],
    ]
];