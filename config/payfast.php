<?php

return [
        'merchant_id' => env('PAYFAST_MERCHANT_ID'),
        'merchant_key' => env('PAYFAST_MERCHANT_KEY'),
        'passphrase' => env('PAYFAST_PASSPHRASE'),
        'sandbox' => env('PAYFAST_TEST_MODE', true),
        'return_url' => env('PAYFAST_RETURN_URL'),
        'cancel_url' => env('PAYFAST_CANCEL_URL'),
        'notify_url' => env('PAYFAST_NOTIFY_URL'),
        'test_mode' => env('PAYFAST_TEST_MODE', true),
];
