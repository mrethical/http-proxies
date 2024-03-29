<?php

use Mrethical\HttpProxies\Exceptions\MissingProxyException;
use Mrethical\HttpProxies\Facades\HttpProxies;
use Mrethical\HttpProxies\Models\Proxy;

beforeEach(function () {
    Proxy::create([
        'ip' => '1.2.3.4',
        'port' => 80,
        'is_active' => true,
    ]);
});

it('fails when there are no active ips', function () {
    Proxy::query()->update(['is_active' => false]);

    HttpProxies::createClient();
})->throws(MissingProxyException::class);
