# Filament Request Analytics

[![Latest Version on Packagist](https://img.shields.io/packagist/v/me-shaon/filament-request-analytics.svg?style=flat-square)](https://packagist.org/packages/me-shaon/filament-request-analytics)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/me-shaon/filament-request-analytics/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/me-shaon/filament-request-analytics/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/me-shaon/filament-request-analytics/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/me-shaon/filament-request-analytics/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/me-shaon/filament-request-analytics.svg?style=flat-square)](https://packagist.org/packages/me-shaon/filament-request-analytics)

A powerful Filament admin panel plugin that provides comprehensive request analytics and visitor insights for your Laravel applications. Built on top of the robust [laravel-request-analytics](https://github.com/me-shaon/laravel-request-analytics) package, this plugin seamlessly integrates analytics tracking with beautiful Filament UI components.

## ✨ Features

- **📊 Real-time Analytics Dashboard** - Beautiful, responsive dashboard with interactive charts and metrics
- **🎯 Comprehensive Tracking** - Visitor behavior, page views, traffic sources, and performance metrics
- **🌍 Geographic Insights** - Country, city, and timezone analytics with IP geolocation
- **📱 Device & Browser Analytics** - Detailed breakdown of devices, browsers, and operating systems
- **🔍 Traffic Source Analysis** - Referrer tracking and search engine traffic insights
- **⚡ Performance Monitoring** - Page load times, bounce rates, and user engagement metrics
- **🛡️ Privacy Compliant** - IP anonymization and Do Not Track support
- **🤖 Bot Detection** - Advanced bot filtering for accurate analytics
- **🎨 Fully Configurable** - Customize dashboard layout, metrics, and appearance
- **🔌 Filament Integration** - Native Filament components and theming support

## 📋 Requirements

- PHP 8.1+
- Laravel 10.0+
- Filament 3.0+
- [laravel-request-analytics](https://github.com/me-shaon/laravel-request-analytics) package

## 🚀 Installation

### Step 1: Install the Laravel Request Analytics Package

First, install the core analytics package:

```bash
composer require me-shaon/laravel-request-analytics
```

### Step 2: Install the Filament Plugin

```bash
composer require me-shaon/filament-request-analytics
```


### Step 3: Register the Plugin

Add the plugin to your Filament panel provider:

```php
// app/Providers/Filament/AdminPanelProvider.php

use Meshaon\FilamentRequestAnalytics\FilamentRequestAnalyticsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentRequestAnalyticsPlugin::make(),
        ]);
}
```

### Step 4: Configure Analytics (Optional)

Publish and configure the core analytics settings:

```bash
php artisan vendor:publish --provider="MeShaon\RequestAnalytics\RequestAnalyticsServiceProvider"
```

## 📖 Usage

### Dashboard Access

Once installed, the analytics dashboard will be available in your Filament admin panel navigation. The dashboard provides:

- **Overview Metrics**: Total views, visitors, bounce rate, and average visit time
- **Traffic Charts**: Interactive line charts showing traffic trends
- **Top Pages**: Most visited pages with view counts
- **Referrer Analysis**: Traffic sources and search engine data
- **Geographic Data**: Country and city analytics
- **Device Analytics**: Browser, OS, and device breakdowns

### Configuration

The dashboard is fully configurable through the `config/request-analytics.php` file:

```php
return [
    'dashboard' => [
        // Navigation configuration
        'navigation' => [
            'icon' => 'heroicon-o-chart-bar',
            'label' => 'Analytics',
            'sort' => 100,
            'group' => null,
        ],

        // Page configuration
        'page' => [
            'title' => 'Analytics Dashboard',
            'description' => 'Track your website performance and user insights',
        ],

        // Default values
        'defaults' => [
            'date_range' => 30, // days
            'request_category' => '', // empty for all requests
        ],

        // Layout configuration
        'layout' => [
            'metrics_grid_columns' => 4,
            'charts_grid_columns' => 2,
            'analytics_grid_columns' => 2,
        ],

        // Request categories
        'request_categories' => [
            '' => 'All Requests',
            'web' => 'Web Only',
            'api' => 'API Only',
        ],

        // Metrics configuration
        'metrics' => [
            'views' => ['label' => 'Views', 'enabled' => true],
            'visitors' => ['label' => 'Visitors', 'enabled' => true],
            'bounce_rate' => ['label' => 'Bounce Rate', 'enabled' => true],
            'average_visit_time' => ['label' => 'Average Visit Time', 'enabled' => true],
        ],

        // Charts configuration
        'charts' => [
            'traffic_overview' => [
                'title' => 'Traffic Overview',
                'description' => 'Daily visitor and page view trends',
                'type' => 'line',
                'enabled' => true,
            ],
        ],

        // Analytics sections
        'sections' => [
            'pages' => ['enabled' => true, 'title' => 'Top Pages'],
            'referrers' => ['enabled' => true, 'title' => 'Top Referrers'],
            'browsers' => ['enabled' => true, 'title' => 'Browser Analytics'],
            'operating_systems' => ['enabled' => true, 'title' => 'Operating Systems'],
            'devices' => ['enabled' => true, 'title' => 'Device Analytics'],
            'countries' => ['enabled' => true, 'title' => 'Country Analytics'],
        ],
    ],
];
```

### Customization Examples

#### Disable Specific Metrics

```php
'metrics' => [
    'views' => ['label' => 'Page Views', 'enabled' => true],
    'visitors' => ['label' => 'Unique Visitors', 'enabled' => true],
    'bounce_rate' => ['label' => 'Bounce Rate %', 'enabled' => false], // Disabled
    'average_visit_time' => ['label' => 'Visit Duration', 'enabled' => true],
],
```

#### Custom Navigation

```php
'navigation' => [
    'icon' => 'heroicon-o-chart-pie',
    'label' => 'My Analytics',
    'sort' => 50,
    'group' => 'Reports',
],
```

#### Disable Sections

```php
'sections' => [
    'pages' => ['enabled' => true, 'title' => 'Popular Pages'],
    'referrers' => ['enabled' => false], // Hidden
    'browsers' => ['enabled' => true, 'title' => 'Browser Stats'],
    'countries' => ['enabled' => false], // Hidden
],
```

## 🔧 Advanced Configuration

### Core Analytics Configuration

The plugin relies on the [laravel-request-analytics](https://github.com/me-shaon/laravel-request-analytics) package for data collection. Configure the core analytics settings:

```php
// config/request-analytics.php (core package config)

return [
    'tracking' => [
        'enabled' => env('REQUEST_ANALYTICS_ENABLED', true),
        'exclude_routes' => [
            'admin/*',
            'api/health',
        ],
        'exclude_user_agents' => [
            'bot',
            'crawler',
            'spider',
        ],
    ],

    'privacy' => [
        'anonymize_ip' => env('REQUEST_ANALYTICS_ANONYMIZE_IP', false),
        'respect_dnt' => env('REQUEST_ANALYTICS_RESPECT_DNT', true),
    ],

    'geolocation' => [
        'enabled' => true,
        'provider' => 'ipapi', // ipapi, ipgeolocation, maxmind
        'api_key' => env('REQUEST_ANALYTICS_GEO_API_KEY'),
    ],
];
```

### Access Control

Implement access control by extending the dashboard class:

```php
// app/Filament/Pages/AnalyticsDashboard.php

use MeShaon\RequestAnalytics\Filament\Pages\AnalyticsDashboard;

class CustomAnalyticsDashboard extends AnalyticsDashboard
{
    public static function canAccess(): bool
    {
        return auth()->user()->can('view-analytics');
    }
}
```

### Custom Dashboard Layout

Override the dashboard view for complete customization:

```bash
php artisan vendor:publish --tag="filament-request-analytics-views"
```

## 🎨 Theming & Customization

The dashboard uses Filament's theming system and can be customized through:

- **CSS Variables**: Override Filament's CSS custom properties
- **View Publishing**: Customize blade templates
- **Component Overrides**: Extend or replace dashboard components

### Custom Styling

```css
/* resources/css/filament/admin/theme.css */

.filament-request-analytics-dashboard {
    --analytics-primary-color: rgb(var(--primary-600));
    --analytics-grid-gap: 1.5rem;
}
```

## 📊 Dashboard Features

### Real-time Metrics
- **Page Views**: Total page views with trend indicators
- **Unique Visitors**: Distinct visitor count with session tracking
- **Bounce Rate**: Percentage of single-page sessions
- **Average Visit Time**: Mean session duration

### Interactive Charts
- **Traffic Overview**: Line charts showing daily trends
- **Geographic Distribution**: Country and city analytics
- **Device Breakdown**: Desktop, mobile, and tablet usage
- **Browser Analytics**: Browser market share data

### Data Filtering
- **Date Range**: Custom date range selection
- **Request Categories**: Filter by web, API, or all requests
- **Real-time Updates**: Live data refresh capabilities

## 🔍 Troubleshooting

### Common Issues

**Dashboard not showing data:**
1. Ensure the core analytics package is properly installed and configured
2. Check that tracking is enabled in the core package configuration
3. Verify database migrations have been run
4. Check Laravel logs for any errors

**Permission denied:**
1. Ensure your user has access to the Filament panel
2. Implement custom access control if needed
3. Check Filament panel configuration

**Performance issues:**
1. Consider adding database indexes for large datasets
2. Configure query caching for better performance
3. Use database connection pooling for high-traffic sites

### Debug Mode

Enable debug mode for development:

```php
// config/request-analytics.php

'tracking' => [
    'debug' => env('REQUEST_ANALYTICS_DEBUG', false),
],
```

## 🧪 Testing

Run the test suite:

```bash
composer test
```

Run tests with coverage:

```bash
composer test-coverage
```

## 📚 Related Packages

- [laravel-request-analytics](https://github.com/me-shaon/laravel-request-analytics) - Core analytics package
- [Filament](https://filamentphp.com/) - Admin panel framework
- [Laravel](https://laravel.com/) - PHP web framework

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](.github/CONTRIBUTING.md) for details.

### Development Setup

1. Fork the repository
2. Clone your fork
3. Install dependencies: `composer install`
4. Run tests: `composer test`
5. Create a pull request

## 📄 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 🔒 Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## 💖 Credits

- [Ahmed Shamim](https://github.com/me-shaon) - Creator and maintainer
- [Laravel Request Analytics](https://github.com/me-shaon/laravel-request-analytics) - Core analytics engine
- [Filament Team](https://filamentphp.com/) - Amazing admin panel framework
- [All Contributors](../../contributors) - Thank you for your contributions!

## 📜 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

**Built with ❤️ for the Laravel and Filament communities**
