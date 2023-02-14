<?php

namespace Mrethical\HttpProxies\Commands;

use Closure;
use Illuminate\Console\Command;
use Mrethical\HttpProxies\HttpProxies;
use Mrethical\HttpProxies\Models\Proxy;

class CheckProxiesCommand extends Command
{
    public $signature = 'http-proxies:check';

    public $description = 'Check if proxies are still active';

    protected static ?Closure $checker = null;

    public function handle(): int
    {
        foreach (Proxy::all() as $proxy) {
            if (! is_null(static::$checker)) {
                $bool = (static::$checker)($proxy);
                if (is_bool($bool)) {
                    $proxy->update([
                        'is_active' => $bool,
                    ]);
                }
            } else {
                $proxy->update([
                    'is_active' => app(HttpProxies::class)->ping($proxy),
                ]);
            }
        }

        return self::SUCCESS;
    }

    public static function setCheckerFunction(Closure $checker)
    {
        self::$checker = $checker;
    }
}
