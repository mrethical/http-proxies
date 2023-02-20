<?php

namespace Mrethical\HttpProxies\Commands;

use Closure;
use Illuminate\Console\Command;
use Mrethical\HttpProxies\HttpProxies;

class PruneProxiesCommand extends Command
{
    public $signature = 'http-proxies:prune {daysOld}';

    public $description = 'Prune inactive proxies';

    protected static ?Closure $checker = null;

    public function handle(): int
    {
        app(HttpProxies::class)->query()
            ->isInactive()
            ->where('updated_at', '<=', now()->subDays(intval($this->argument('daysOld'))))
            ->delete();

        return self::SUCCESS;
    }

    public static function setCheckerFunction(Closure $checker)
    {
        self::$checker = $checker;
    }
}
