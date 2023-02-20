<?php

namespace Mrethical\HttpProxies\Commands;

use Illuminate\Console\Command;
use Mrethical\HttpProxies\HttpProxies;

class AddProxiesCommand extends Command
{
    public $signature = 'http-proxies:add {ip} {--port=}';

    public $description = 'Add a proxy';

    public function handle(): int
    {
        $ip = $this->argument('ip');
        $port = intval($this->option('port')) ?: 80;

        if (app(HttpProxies::class)->query()->where('ip', $ip)->exists()) {
            $this->error('IP already exists');

            return self::FAILURE;
        }

        $data = [
            'ip' => $ip,
            'port' => $port,
            'is_active' => true,
        ];

        if (! app(HttpProxies::class)->ping(new (get_class(app(HttpProxies::class)->getModel()))($data))) {
            $this->error('IP not working');

            return self::FAILURE;
        }

        app(HttpProxies::class)->query()->create($data);

        return self::SUCCESS;
    }
}
