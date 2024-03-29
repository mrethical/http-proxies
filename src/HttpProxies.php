<?php

namespace Mrethical\HttpProxies;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Database\Eloquent\Builder;
use Mrethical\HttpProxies\Exceptions\MissingProxyException;
use Mrethical\HttpProxies\Models\Proxy;

class HttpProxies
{
    public function __construct(protected Proxy $model)
    {
    }

    public function getModel(): Proxy
    {
        return $this->model;
    }

    public function query(): Builder
    {
        return $this->getModel()->newQuery();
    }

    public function createClient(Proxy $proxy = null, $config = []): GuzzleClient
    {
        if (is_null($proxy)) {
            $proxy = $this->query()
                ->isActive()
                ->inRandomOrder()
                ->first();
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
