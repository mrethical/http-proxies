<?php

namespace Mrethical\HttpProxies;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Mrethical\HttpProxies\Exceptions\MissingProxyException;
use Mrethical\HttpProxies\Models\Proxy;

class HttpProxies
{
    public function createClient(Proxy $proxy = null, $config = []): GuzzleClient
    {
        if (is_null($proxy)) {
            $proxy = Proxy::isActive()->inRandomOrder()->first();
        }

        if (is_null($proxy)) {
            throw new MissingProxyException('There are no active proxies');
        }

        $config['proxy'] = 'http://'.$proxy->ipPort;

        return new GuzzleClient($config);
    }

    public function ping(Proxy $proxy): bool
    {
        $client = $this->createClient($proxy);

        try {
            $response = $client->get('https://google.com');

            return $response->getStatusCode() === 200;
        } catch (Exception) {
            return false;
        }
    }
}
