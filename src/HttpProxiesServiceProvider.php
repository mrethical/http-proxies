<?php

namespace Mrethical\HttpProxies;

use Mrethical\HttpProxies\Commands\AddProxiesCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HttpProxiesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('http-proxies')
            ->hasMigration('create_http-proxies_table')
            ->hasCommand(AddProxiesCommand::class);
    }
}
