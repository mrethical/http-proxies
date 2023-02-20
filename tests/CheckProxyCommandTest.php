<?php

use Illuminate\Support\Facades\Artisan;
use Mockery\MockInterface;
use Mrethical\HttpProxies\Commands\CheckProxiesCommand;
use Mrethical\HttpProxies\HttpProxies;
use Mrethical\HttpProxies\Models\Proxy;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\partialMock;

beforeEach(function () {
    Proxy::create([
        'ip' => '1.2.3.4',
        'port' => 80,
        'is_active' => true,
    ]);
});

it('marks proxy as inactive when ping fails', function () {
    partialMock(
        HttpProxies::class,
        function (MockInterface $mock) {
            $mock->shouldReceive('getModel')
                ->andReturn(new Proxy());
            $mock->shouldReceive('ping')
                ->andReturn(false);
        }
    );

    Artisan::call('http-proxies:check');

    assertDatabaseHas('proxies', [
        'id' => 1,
        'ip' => '1.2.3.4',
        'port' => 80,
        'is_active' => false,
    ]);
});

it('accepts custom ping', function () {
    CheckProxiesCommand::setCheckerFunction(fn () => false);

    Artisan::call('http-proxies:check');

    assertDatabaseHas('proxies', [
        'id' => 1,
        'ip' => '1.2.3.4',
        'port' => 80,
        'is_active' => false,
    ]);
});

it('ignores custom ping on demand', function () {
    partialMock(
        HttpProxies::class,
        function (MockInterface $mock) {
            $mock->shouldReceive('getModel')
                ->andReturn(new Proxy());
            $mock->shouldReceive('ping')
                ->andReturn(false);
        }
    );

    CheckProxiesCommand::setCheckerFunction(fn () => true);

    Artisan::call('http-proxies:check --default');

    assertDatabaseHas('proxies', [
        'id' => 1,
        'ip' => '1.2.3.4',
        'port' => 80,
        'is_active' => false,
    ]);
});
