<?php

namespace Mrethical\HttpProxies\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mrethical\HttpProxies\HttpProxies
 */
class HttpProxies extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mrethical\HttpProxies\HttpProxies::class;
    }
}
