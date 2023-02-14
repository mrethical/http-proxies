<?php

namespace Mrethical\HttpProxies\Commands;

use Illuminate\Console\Command;
use Mrethical\HttpProxies\HttpProxies;
use Mrethical\HttpProxies\Models\Proxy;

class AddProxiesCommand extends Command
{
    public $signature = 'http-proxies:add {ip} {--port=}';

    public $description = 'Add a proxy';

    public function handle(): int
    {
        $ip = $this->argument('ip');
        $port = intval($this->option('port')) ?: 80;

        if (Proxy::where('ip', $ip)->exists()) {
            $this->error('IP already exists');

            return self::FAILURE;
        }

        $data = [
            'ip' => $ip,
            'port' => $port,
            'is_active' => true,
        ];

        if (! app(HttpProxies::class)->ping(new Proxy($data))) {
            $this->error('IP not working');

            return self::FAILURE;
        }

        Proxy::create($data);

        return self::SUCCESS;
    }
}
