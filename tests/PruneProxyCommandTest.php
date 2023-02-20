<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mrethical\HttpProxies\Models\Proxy;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $proxyTable = (new Proxy())->getTable();

    DB::table($proxyTable)->insert([
        'ip' => '1.2.3.40',
        'port' => 80,
        'is_active' => false,
        'created_at' => now()->subDays(14),
        'updated_at' => now()->subDays(14),
    ]);
    Proxy::create([
        'ip' => '1.2.3.41',
        'port' => 80,
        'is_active' => true,
        'created_at' => now()->subDays(14),
        'updated_at' => now()->subDays(14),
    ]);
    Proxy::create([
        'ip' => '1.2.3.42',
        'port' => 80,
        'is_active' => false,
        'created_at' => now()->subDays(7),
        'updated_at' => now()->subDays(7),
    ]);
});

it('prunes proxies by age', function () {
    Artisan::call('http-proxies:prune', ['daysOld' => 10]);

    assertDatabaseMissing('proxies', ['ip' => '1.2.3.40']);
    assertDatabaseHas('proxies', ['ip' => '1.2.3.41']);
    assertDatabaseHas('proxies', ['ip' => '1.2.3.42']);
});
