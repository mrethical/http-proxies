<?php

// config for Mrethical/HttpProxies
return [
    'model' => Mrethical\HttpProxies\Models\Proxy::class,
    'selenium' => [
        'url' => env('SELENIUM_URL', 'http://localhost:4444'),
        'timeouts' => [
            'connection' => env('SELENIUM_CONNECTION_TIMEOUT'),
            'request' => env('SELENIUM_REQUEST_TIMEOUT'),
            'pageload' => env('SELENIUM_PAGELOAD_TIMEOUT'),
            'script' => env('SELENIUM_SCRIPT_TIMEOUT'),
        ],
    ],
];
