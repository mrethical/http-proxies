# Use http proxies within your Laravel application

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrethical/http-proxies.svg?style=flat-square)](https://packagist.org/packages/mrethical/http-proxies)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mrethical/http-proxies/run-tests?label=tests)](https://github.com/mrethical/http-proxies/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mrethical/http-proxies/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/mrethical/http-proxies/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mrethical/http-proxies.svg?style=flat-square)](https://packagist.org/packages/mrethical/http-proxies)

This package help you set up a simple ip proxies management. It can also give you a GuzzleClient with a fresh active proxy set.

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

## Usage

Add a proxy by calling the `http-proxies:add` command

```bash
php artisan http-proxies:add 1.2.3.4 --port=80
```

On your code, get a GuzzleClient with a fresh active proxy.

```php
$client = app(\Mrethical\HttpProxies\Client::class);
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
