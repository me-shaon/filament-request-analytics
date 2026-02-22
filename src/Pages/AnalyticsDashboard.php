<?php

declare(strict_types=1);

namespace Meshaon\FilamentRequestAnalytics\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use MeShaon\RequestAnalytics\Services\DashboardAnalyticsService;

class AnalyticsDashboard extends Page
{
    protected static ?string $navigationIcon;

    protected static string $view = 'analytics-dashboard';

    protected static ?string $title;

    protected static ?string $navigationLabel;

    protected static ?int $navigationSort;

    public array $dateRange = [];

    public string $requestCategory = '';

    public string $startDate = '';

    public string $endDate = '';

    public static function booted(): void
    {
        static::$navigationIcon = config('request-analytics.dashboard.navigation.icon');
        static::$navigationLabel = config('request-analytics.dashboard.navigation.label');
        static::$navigationSort = config('request-analytics.dashboard.navigation.sort');
        static::$title = config('request-analytics.dashboard.page.title');
    }

    public function getTitle(): string | Htmlable
    {
        return config('request-analytics.dashboard.page.title');
    }

    public function getViewData(): array
    {
        $dashboardService = app(DashboardAnalyticsService::class);

        $params = [];

        if (! empty($this->startDate) && ! empty($this->endDate)) {
            $params['start_date'] = $this->startDate;
            $params['end_date'] = $this->endDate;
        } else {
            $defaultDateRange = config('request-analytics.dashboard.defaults.date_range', 30);
            $dateRangeInput = request('date_range', $defaultDateRange);
            $dateRange = is_numeric($dateRangeInput) && (int) $dateRangeInput > 0
                ? (int) $dateRangeInput
                : $defaultDateRange;
            $params['date_range'] = $dateRange;
        }

        $params['request_category'] = ! empty($this->requestCategory) ? $this->requestCategory : null;

        return $dashboardService->getDashboardData($params);
    }

    public function mount(): void
    {
        $this->startDate = request('start_date', '');
        $this->endDate = request('end_date', '');
        $this->requestCategory = request('request_category', config('request-analytics.dashboard.defaults.request_category', ''));
    }

    /**
     * Get configuration value with fallback
     */
    public function getConfig(string $key, mixed $default = null): mixed
    {
        return config("request-analytics.dashboard.{$key}", $default);
    }

    /**
     * Get dashboard configuration
     */
    public function getDashboardConfig(): array
    {
        return config('request-analytics.dashboard', []);
    }

    /**
     * Get enabled metrics
     */
    public function getEnabledMetrics(): array
    {
        $metrics = config('request-analytics.dashboard.metrics', []);

        return array_filter($metrics, fn ($metric) => $metric['enabled'] ?? true);
    }

    /**
     * Get enabled sections
     */
    public function getEnabledSections(): array
    {
        $sections = config('request-analytics.dashboard.sections', []);

        return array_filter($sections, fn ($section) => $section['enabled'] ?? true);
    }

    /**
     * Get request categories configuration
     */
    public function getRequestCategories(): array
    {
        return config('request-analytics.dashboard.request_categories', []);
    }

    /**
     * Get layout configuration
     */
    public function getLayoutConfig(): array
    {
        return config('request-analytics.dashboard.layout', []);
    }

    /**
     * Get charts configuration
     */
    public function getChartsConfig(): array
    {
        $charts = config('request-analytics.dashboard.charts', []);

        return array_filter($charts, fn ($chart) => $chart['enabled'] ?? true);
    }

    /**
     * Get navigation icon for testing
     */
    public static function getTestNavigationIcon(): ?string
    {
        return static::$navigationIcon;
    }

    /**
     * Get navigation label for testing
     */
    public static function getTestNavigationLabel(): ?string
    {
        return static::$navigationLabel;
    }

    /**
     * Get navigation sort for testing
     */
    public static function getTestNavigationSort(): ?int
    {
        return static::$navigationSort;
    }

    /**
     * Get view for testing
     */
    public static function getTestView(): string
    {
        return static::$view;
    }

    /**
     * Get title for testing
     */
    public static function getTestPageTitle(): ?string
    {
        return static::$title;
    }
}
