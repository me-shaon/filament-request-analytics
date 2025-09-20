<?php

declare(strict_types=1);

namespace MeShaon\RequestAnalytics\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use MeShaon\RequestAnalytics\Services\DashboardAnalyticsService;

class AnalyticsDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'analytics-dashboard';

    protected static ?string $title = 'Analytics Dashboard';

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?int $navigationSort = 100;

    public array $dateRange = [];
    public string $requestCategory = '';
    public string $startDate = '';
    public string $endDate = '';

    public function getTitle(): string|Htmlable
    {
        return 'Analytics Dashboard';
    }

    public function getViewData(): array
    {
        $dashboardService = app(DashboardAnalyticsService::class);
        
        $params = [];
        
        if (!empty($this->startDate) && !empty($this->endDate)) {
            $params['start_date'] = $this->startDate;
            $params['end_date'] = $this->endDate;
        } else {
            $dateRangeInput = request('date_range', 30);
            $dateRange = is_numeric($dateRangeInput) && (int) $dateRangeInput > 0
                ? (int) $dateRangeInput
                : 30;
            $params['date_range'] = $dateRange;
        }
        
        $params['request_category'] = !empty($this->requestCategory) ? $this->requestCategory : null;
        
        return $dashboardService->getDashboardData($params);
    }

    public function mount(): void
    {
        $this->startDate = request('start_date', '');
        $this->endDate = request('end_date', '');
        $this->requestCategory = request('request_category', '');
    }
}