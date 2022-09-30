<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Mockery\MockInterface;
use Mrethical\HttpProxies\HttpProxies;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\instance;
use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    instance(
        HttpProxies::class,
        Mockery::mock(HttpProxies::class, function (MockInterface $mock) {
            $guzzleMock = new MockHandler([new Response(200)]);
            $guzzleClient = new GuzzleClient(['handler' => HandlerStack::create($guzzleMock)]);

            $mock->shouldReceive('createClient')
                ->andReturn($guzzleClient);
        })
    );
});

it('can add proxy', function () {
    Artisan::call('http-proxies:add', [
        'ip' => '1.2.3.4',
        '--port' => 80,
    ]);

    assertDatabaseHas('proxies', [
        'id' => 1,
        'ip' => '1.2.3.4',
        'port' => 80,
        'is_active' => true,
    ]);
});

it('fails when proxy already exists', function () {
    $statusCode = Artisan::call('http-proxies:add', [
        'ip' => '1.2.3.4',
        '--port' => 80,
    ]);

    assertEquals(Command::SUCCESS, $statusCode);

    $statusCode = Artisan::call('http-proxies:add', [
        'ip' => '1.2.3.4',
        '--port' => 80,
    ]);

    assertEquals(Command::FAILURE, $statusCode);
});

it('fails when proxy is not working', function () {
    instance(
        HttpProxies::class,
        Mockery::mock(HttpProxies::class, function (MockInterface $mock) {
            $guzzleMock = new MockHandler([new Response(400)]);
            $guzzleClient = new GuzzleClient(['handler' => HandlerStack::create($guzzleMock)]);

            $mock->shouldReceive('createClient')
                ->andReturn($guzzleClient);
        })
    );

    $statusCode = Artisan::call('http-proxies:add', [
        'ip' => '1.2.3.4',
        '--port' => 80,
    ]);

    assertEquals(Command::FAILURE, $statusCode);
});
