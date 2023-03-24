<?php

// config for Mrethical/HttpProxies
return [
    'model' => Mrethical\HttpProxies\Models\Proxy::class,
    'selenium' => [
        'url' => env('SELENIUM_URL', 'http://localhost:4444'),
    ],
];
