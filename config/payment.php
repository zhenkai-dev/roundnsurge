<?php

return [
    'sandbox_mode' => env('PAYMENT_SANDBOX_MODE', true),
    'invoice_prefix' => date('Y'),
    'invoice_initial_number' => 1000,

    'paypal' => [
        'business_email' => env('PAYPAL_BUSINESS_EMAIL', 'kitloo_1352255941_biz@hotmail.com')
    ]
];