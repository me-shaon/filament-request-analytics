# Simple request data analytics package for Filament projects

[![Latest Version on Packagist](https://img.shields.io/packagist/v/me-shaon/filament-request-analytics.svg?style=flat-square)](https://packagist.org/packages/me-shaon/filament-request-analytics)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/me-shaon/filament-request-analytics/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/me-shaon/filament-request-analytics/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/me-shaon/filament-request-analytics/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/me-shaon/filament-request-analytics/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/me-shaon/filament-request-analytics.svg?style=flat-square)](https://packagist.org/packages/me-shaon/filament-request-analytics)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require me-shaon/filament-request-analytics
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-request-analytics-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-request-analytics-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-request-analytics-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentRequestAnalytics = new Meshaon\FilamentRequestAnalytics();
echo $filamentRequestAnalytics->echoPhrase('Hello, Meshaon!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ahmed shamim](https://github.com/me-shaon)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
