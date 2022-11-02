<?php

return [
    'except' => [],
    'hash_algo' => 'md5',
    'separator' => '.',
    'merchant_key' => env('SECOND_APP_KEY', ''),
    'payment_limit' => env('SECOND_PAYMENT_LIMIT', 0),
    'signature_name' => 'Authorization',
    'signature_source' => 'header'
];
