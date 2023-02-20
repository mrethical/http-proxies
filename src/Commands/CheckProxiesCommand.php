<?php

namespace Mrethical\HttpProxies\Commands;

use Closure;
use Illuminate\Console\Command;
use Mrethical\HttpProxies\HttpProxies;

class CheckProxiesCommand extends Command
{
    public $signature = 'http-proxies:check {--default}';

    public $description = 'Check if proxies are still active';

    protected static ?Closure $checker = null;

    public function handle(): int
    {
        $default = $this->option('default');

        foreach (app(HttpProxies::class)->query()->get() as $proxy) {
            /** @var \Mrethical\HttpProxies\Models\Proxy $proxy */
            if (! $default && ! is_null(static::$checker)) {
                $bool = (static::$checker)($proxy);
                if (is_bool($bool)) {
                    $proxy->is_active = $bool;
                }
            } else {
                $proxy->is_active = app(HttpProxies::class)->ping($proxy);
            }
            $proxy->save();
        }

        return self::SUCCESS;
    }

    public static function setCheckerFunction(Closure $checker)
    {
        self::$checker = $checker;
    }
}
