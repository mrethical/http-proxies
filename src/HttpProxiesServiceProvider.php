<?php

namespace Mrethical\HttpProxies;

use Mrethical\HttpProxies\Commands\AddProxiesCommand;
use Mrethical\HttpProxies\Commands\CheckProxiesCommand;
use Mrethical\HttpProxies\Commands\PruneProxiesCommand;
use Mrethical\HttpProxies\Models\Proxy;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HttpProxiesServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->bind(Proxy::class, fn () => new ($this->app['config']['http-proxies.model']));
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('http-proxies')
            ->hasConfigFile()
            ->hasMigration('create_http-proxies_table')
            ->hasCommands(
                AddProxiesCommand::class,
                CheckProxiesCommand::class,
                PruneProxiesCommand::class,
            );
    }
}
