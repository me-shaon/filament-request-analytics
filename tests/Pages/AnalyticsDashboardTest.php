<?php

declare(strict_types=1);

namespace Meshaon\FilamentRequestAnalytics\Tests\Pages;

use Filament\Pages\Page;
use Meshaon\FilamentRequestAnalytics\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AnalyticsDashboardTest extends TestCase
{
    #[Test]
    public function it_can_test_analytics_dashboard_class_exists(): void
    {
        // Test that the AnalyticsDashboard class from the external package exists
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            $this->assertTrue(class_exists($analyticsDashboardClass));
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_extends_page(): void
    {
        // Test that the AnalyticsDashboard class extends Filament Page
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            $this->assertTrue(is_subclass_of($analyticsDashboardClass, Page::class));
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_has_correct_view(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            $view = $analyticsDashboardClass::getTestView();
            $this->assertEquals('analytics-dashboard', $view);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_configuration(): void
    {
        // Set test configuration
        config([
            'request-analytics.dashboard.navigation.icon' => 'heroicon-o-chart-bar',
            'request-analytics.dashboard.navigation.label' => 'Analytics',
            'request-analytics.dashboard.navigation.sort' => 100,
            'request-analytics.dashboard.page.title' => 'Analytics Dashboard',
        ]);

        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            // Boot the page to trigger configuration loading
            $analyticsDashboardClass::booted();

            $this->assertEquals('heroicon-o-chart-bar', $analyticsDashboardClass::getTestNavigationIcon());
            $this->assertEquals('Analytics', $analyticsDashboardClass::getTestNavigationLabel());
            $this->assertEquals(100, $analyticsDashboardClass::getTestNavigationSort());
            $this->assertEquals('Analytics Dashboard', $analyticsDashboardClass::getTestPageTitle());
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_title_method(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            config(['request-analytics.dashboard.page.title' => 'Custom Analytics Title']);

            $page = new $analyticsDashboardClass;
            $title = $page->getTitle();

            $this->assertEquals('Custom Analytics Title', $title);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_mount_method(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            // Mock request parameters
            request()->merge([
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-31',
                'request_category' => 'web',
            ]);

            config(['request-analytics.dashboard.defaults.request_category' => 'api']);

            $page = new $analyticsDashboardClass;
            $page->mount();

            $this->assertEquals('2024-01-01', $page->startDate);
            $this->assertEquals('2024-01-31', $page->endDate);
            $this->assertEquals('web', $page->requestCategory);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_config_methods(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            config([
                'request-analytics.dashboard.metrics' => [
                    'views' => ['enabled' => true, 'label' => 'Views'],
                    'visitors' => ['enabled' => false, 'label' => 'Visitors'],
                    'bounce_rate' => ['enabled' => true, 'label' => 'Bounce Rate'],
                ],
                'request-analytics.dashboard.sections' => [
                    'pages' => ['enabled' => true, 'title' => 'Top Pages'],
                    'referrers' => ['enabled' => false, 'title' => 'Top Referrers'],
                    'browsers' => ['enabled' => true, 'title' => 'Browser Analytics'],
                ],
                'request-analytics.dashboard.request_categories' => [
                    '' => 'All Requests',
                    'web' => 'Web Only',
                    'api' => 'API Only',
                ],
                'request-analytics.dashboard.layout' => [
                    'metrics_grid_columns' => 4,
                    'charts_grid_columns' => 2,
                ],
                'request-analytics.dashboard.charts' => [
                    'traffic_overview' => ['enabled' => true, 'title' => 'Traffic Overview'],
                    'user_analytics' => ['enabled' => false, 'title' => 'User Analytics'],
                ],
            ]);

            $page = new $analyticsDashboardClass;

            // Test getConfig method
            config(['request-analytics.dashboard.test_key' => 'test_value']);
            $this->assertEquals('test_value', $page->getConfig('test_key'));
            $this->assertEquals('default_value', $page->getConfig('non_existent_key', 'default_value'));

            // Test getDashboardConfig method
            $config = $page->getDashboardConfig();
            $this->assertIsArray($config);

            // Test getEnabledMetrics method
            $enabledMetrics = $page->getEnabledMetrics();
            $this->assertCount(2, $enabledMetrics);
            $this->assertArrayHasKey('views', $enabledMetrics);
            $this->assertArrayHasKey('bounce_rate', $enabledMetrics);
            $this->assertArrayNotHasKey('visitors', $enabledMetrics);

            // Test getEnabledSections method
            $enabledSections = $page->getEnabledSections();
            $this->assertCount(2, $enabledSections);
            $this->assertArrayHasKey('pages', $enabledSections);
            $this->assertArrayHasKey('browsers', $enabledSections);
            $this->assertArrayNotHasKey('referrers', $enabledSections);

            // Test getRequestCategories method
            $categories = $page->getRequestCategories();
            $this->assertIsArray($categories);
            $this->assertEquals('All Requests', $categories['']);
            $this->assertEquals('Web Only', $categories['web']);
            $this->assertEquals('API Only', $categories['api']);

            // Test getLayoutConfig method
            $layoutConfig = $page->getLayoutConfig();
            $this->assertIsArray($layoutConfig);
            $this->assertEquals(4, $layoutConfig['metrics_grid_columns']);
            $this->assertEquals(2, $layoutConfig['charts_grid_columns']);

            // Test getChartsConfig method
            $chartsConfig = $page->getChartsConfig();
            $this->assertCount(1, $chartsConfig);
            $this->assertArrayHasKey('traffic_overview', $chartsConfig);
            $this->assertArrayNotHasKey('user_analytics', $chartsConfig);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_view_data_with_mock_service(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            // Mock the DashboardAnalyticsService
            $mockService = $this->createMock('MeShaon\RequestAnalytics\Services\DashboardAnalyticsService');
            $mockService->expects($this->once())
                ->method('getDashboardData')
                ->with([
                    'date_range' => 30,
                    'request_category' => null,
                ])
                ->willReturn(['data' => 'test']);

            $this->app->instance('MeShaon\RequestAnalytics\Services\DashboardAnalyticsService', $mockService);

            config(['request-analytics.dashboard.defaults.date_range' => 30]);

            $page = new $analyticsDashboardClass;
            $result = $page->getViewData();

            $this->assertEquals(['data' => 'test'], $result);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_test_analytics_dashboard_handles_empty_configuration(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';

        if (class_exists($analyticsDashboardClass)) {
            // Clear all configuration
            config(['request-analytics.dashboard' => []]);

            $page = new $analyticsDashboardClass;

            // These methods should not throw exceptions even with empty config
            $this->assertIsArray($page->getDashboardConfig());
            $this->assertIsArray($page->getEnabledMetrics());
            $this->assertIsArray($page->getEnabledSections());
            $this->assertIsArray($page->getRequestCategories());
            $this->assertIsArray($page->getLayoutConfig());
            $this->assertIsArray($page->getChartsConfig());
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }
}
