# Use http proxies within your Laravel application

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrethical/http-proxies.svg?style=flat-square)](https://packagist.org/packages/mrethical/http-proxies)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mrethical/http-proxies/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mrethical/http-proxies/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions\workflow/status/mrethical/http-proxies/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mrethical/http-proxies/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mrethical/http-proxies.svg?style=flat-square)](https://packagist.org/packages/mrethical/http-proxies)

This package help you set up a simple ip proxies management. It can also give you a GuzzleClient with a fresh active proxy configured.

## Installation

You can install the package via composer:

```bash
composer require mrethical/http-proxies
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="http-proxies-migrations"
php artisan migrate
```
You can publish the config file with:

```bash
php artisan vendor:publish --tag="http-proxies-config"
```

This is the contents of the published config file:

```php
return [
    'model' => Mrethical\HttpProxies\Models\Proxy::class,
    'selenium' => [
        'url' => env('SELENIUM_URL', 'http://localhost:4444'),
        'timeouts' => [
            'connection' => env('SELENIUM_CONNECTION_TIMEOUT'),
            'request' => env('SELENIUM_REQUEST_TIMEOUT'),
            'pageload' => env('SELENIUM_PAGELOAD_TIMEOUT', 60),
            'script' => env('SELENIUM_SCRIPT_TIMEOUT', 3),
        ],
    ],
];
```
## Usage

Add a proxy by calling the `http-proxies:add` command

```bash
php artisan http-proxies:add 1.2.3.4 --port=80
```

On your code, get a GuzzleClient with a fresh active proxy.

```php
use Mrethical\HttpProxies\HttpProxies;

$client = app(HttpProxies::class)->createClient();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jefferson Magboo](https://github.com/mrethical)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
