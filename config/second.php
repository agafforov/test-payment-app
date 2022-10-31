<?php

return [
    'merchant_id' => env('SECOND_APP_ID', 0),
    'merchant_key' => env('SECOND_APP_KEY', ''),
    'payment_limit' => env('SECOND_PAYMENT_LIMIT', 0),
    'except' => [],
    'hash_algo' => 'md5',
    'separator' => '.',
    'signature_name' => 'Authorization',
    'signature_source' => 'header'
];
