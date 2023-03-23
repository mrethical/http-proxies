<?php

use Illuminate\Support\Facades\DB;
use Mrethical\HttpProxies\Models\Proxy;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

beforeEach(function () {
    $proxyTable = (new Proxy())->getTable();

    DB::table($proxyTable)->insert([
        'ip' => '1.2.3.40',
        'port' => 80,
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    Proxy::create([
        'ip' => '1.2.3.41',
        'port' => 80,
        'is_active' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    Proxy::create([
        'ip' => '1.2.3.42',
        'port' => 80,
        'is_active' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});

it('can mark itself as inactive', function () {
    $activeProxy = Proxy::first();

    assertEquals(true, $activeProxy?->fresh()->is_active);

    $activeProxy?->markAsInactive();

    assertEquals(false, $activeProxy?->fresh()->is_active);
});

it('can get random active proxy', function () {
    $activeProxy = Proxy::firstRandomActive();

    assertEquals(true, $activeProxy?->is_active);

    $activeProxy->markAsInactive();

    assertNull(Proxy::firstRandomActive());
});
