<?php

return [
    'except' => ['sign'],
    'hash_algo' => 'sha256',
    'separator' => ':',
    'merchant_key' => env('FIRST_MERCHANT_KEY', ''),
    'payment_limit' => env('FIRST_PAYMENT_LIMIT', 0),
    'signature_name' => 'sign',
    'signature_source' => 'body'
];
