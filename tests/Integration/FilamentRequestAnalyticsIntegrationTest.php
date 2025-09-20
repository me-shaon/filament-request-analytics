<?php

declare(strict_types=1);

namespace Meshaon\FilamentRequestAnalytics\Tests\Integration;

use Filament\Facades\Filament;
use Filament\Panel;
use Meshaon\FilamentRequestAnalytics\FilamentRequestAnalyticsPlugin;
use Meshaon\FilamentRequestAnalytics\FilamentRequestAnalyticsServiceProvider;
use Meshaon\FilamentRequestAnalytics\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FilamentRequestAnalyticsIntegrationTest extends TestCase
{
    #[Test]
    public function it_can_register_plugin_with_filament_panel(): void
    {
        // Create a test panel
        $panel = Panel::make('test-panel');
        
        // Create and register the plugin
        $plugin = new FilamentRequestAnalyticsPlugin();
        $panel->plugin($plugin);
        
        // Verify the plugin is registered
        $this->assertTrue($panel->hasPlugin('filament-request-analytics'));
    }

    #[Test]
    public function it_registers_analytics_dashboard_page_in_panel(): void
    {
        // Create a test panel
        $panel = Panel::make('test-panel');
        
        // Create and register the plugin
        $plugin = new FilamentRequestAnalyticsPlugin();
        $plugin->register($panel);
        
        // Get the registered pages
        $pages = $panel->getPages();
        
        // Verify AnalyticsDashboard is registered
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        $this->assertContains($analyticsDashboardClass, $pages);
    }

    #[Test]
    public function it_can_boot_plugin_without_errors(): void
    {
        // Create a test panel
        $panel = Panel::make('test-panel');
        
        // Create and register the plugin
        $plugin = new FilamentRequestAnalyticsPlugin();
        $plugin->register($panel);
        
        // Boot should not throw any exceptions
        $this->expectNotToPerformAssertions();
        $plugin->boot($panel);
    }

    #[Test]
    public function it_can_access_analytics_dashboard_page(): void
    {
        // Create a test panel
        $panel = Panel::make('test-panel');
        
        // Create and register the plugin
        $plugin = new FilamentRequestAnalyticsPlugin();
        $plugin->register($panel);
        
        // Get the registered pages
        $pages = $panel->getPages();
        
        // Verify we can instantiate the AnalyticsDashboard page
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        $this->assertContains($analyticsDashboardClass, $pages);
        
        if (class_exists($analyticsDashboardClass)) {
            $page = new $analyticsDashboardClass();
            $this->assertInstanceOf($analyticsDashboardClass, $page);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_configure_analytics_dashboard_from_config(): void
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
    public function it_can_get_dashboard_data_with_service(): void
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
                ->willReturn([
                    'metrics' => [
                        'views' => 1000,
                        'visitors' => 500,
                        'bounce_rate' => 0.3,
                        'average_visit_time' => 120,
                    ],
                    'charts' => [
                        'traffic_overview' => [
                            'labels' => ['2024-01-01', '2024-01-02'],
                            'data' => [100, 150],
                        ],
                    ],
                    'sections' => [
                        'pages' => [
                            ['url' => '/home', 'views' => 100],
                            ['url' => '/about', 'views' => 50],
                        ],
                    ],
                ]);

            $this->app->instance('MeShaon\RequestAnalytics\Services\DashboardAnalyticsService', $mockService);

            // Create and test the page
            $page = new $analyticsDashboardClass();
            $data = $page->getViewData();

            $this->assertIsArray($data);
            $this->assertArrayHasKey('metrics', $data);
            $this->assertArrayHasKey('charts', $data);
            $this->assertArrayHasKey('sections', $data);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_handle_different_date_ranges(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            // Mock the DashboardAnalyticsService
            $mockService = $this->createMock('MeShaon\RequestAnalytics\Services\DashboardAnalyticsService');
            $mockService->expects($this->once())
                ->method('getDashboardData')
                ->with([
                    'start_date' => '2024-01-01',
                    'end_date' => '2024-01-31',
                    'request_category' => 'web',
                ])
                ->willReturn(['data' => 'test']);

            $this->app->instance('MeShaon\RequestAnalytics\Services\DashboardAnalyticsService', $mockService);

            // Create and test the page with specific date range
            $page = new $analyticsDashboardClass();
            $page->startDate = '2024-01-01';
            $page->endDate = '2024-01-31';
            $page->requestCategory = 'web';

            $data = $page->getViewData();

            $this->assertEquals(['data' => 'test'], $data);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_get_enabled_metrics_from_config(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            config([
                'request-analytics.dashboard.metrics' => [
                    'views' => ['enabled' => true, 'label' => 'Views'],
                    'visitors' => ['enabled' => false, 'label' => 'Visitors'],
                    'bounce_rate' => ['enabled' => true, 'label' => 'Bounce Rate'],
                    'average_visit_time' => ['enabled' => true, 'label' => 'Average Visit Time'],
                ],
            ]);

            $page = new $analyticsDashboardClass();
            $enabledMetrics = $page->getEnabledMetrics();

            $this->assertCount(3, $enabledMetrics);
            $this->assertArrayHasKey('views', $enabledMetrics);
            $this->assertArrayHasKey('bounce_rate', $enabledMetrics);
            $this->assertArrayHasKey('average_visit_time', $enabledMetrics);
            $this->assertArrayNotHasKey('visitors', $enabledMetrics);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_get_enabled_sections_from_config(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            config([
                'request-analytics.dashboard.sections' => [
                    'pages' => ['enabled' => true, 'title' => 'Top Pages'],
                    'referrers' => ['enabled' => false, 'title' => 'Top Referrers'],
                    'browsers' => ['enabled' => true, 'title' => 'Browser Analytics'],
                    'operating_systems' => ['enabled' => true, 'title' => 'Operating Systems'],
                    'devices' => ['enabled' => false, 'title' => 'Device Analytics'],
                    'countries' => ['enabled' => true, 'title' => 'Country Analytics'],
                ],
            ]);

            $page = new $analyticsDashboardClass();
            $enabledSections = $page->getEnabledSections();

            $this->assertCount(4, $enabledSections);
            $this->assertArrayHasKey('pages', $enabledSections);
            $this->assertArrayHasKey('browsers', $enabledSections);
            $this->assertArrayHasKey('operating_systems', $enabledSections);
            $this->assertArrayHasKey('countries', $enabledSections);
            $this->assertArrayNotHasKey('referrers', $enabledSections);
            $this->assertArrayNotHasKey('devices', $enabledSections);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_get_enabled_charts_from_config(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            config([
                'request-analytics.dashboard.charts' => [
                    'traffic_overview' => ['enabled' => true, 'title' => 'Traffic Overview'],
                    'user_analytics' => ['enabled' => false, 'title' => 'User Analytics'],
                    'performance' => ['enabled' => true, 'title' => 'Performance'],
                    'conversion' => ['enabled' => true, 'title' => 'Conversion'],
                ],
            ]);

            $page = new $analyticsDashboardClass();
            $enabledCharts = $page->getChartsConfig();

            $this->assertCount(3, $enabledCharts);
            $this->assertArrayHasKey('traffic_overview', $enabledCharts);
            $this->assertArrayHasKey('performance', $enabledCharts);
            $this->assertArrayHasKey('conversion', $enabledCharts);
            $this->assertArrayNotHasKey('user_analytics', $enabledCharts);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_get_request_categories_from_config(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            config([
                'request-analytics.dashboard.request_categories' => [
                    '' => 'All Requests',
                    'web' => 'Web Only',
                    'api' => 'API Only',
                    'mobile' => 'Mobile Only',
                ],
            ]);

            $page = new $analyticsDashboardClass();
            $categories = $page->getRequestCategories();

            $this->assertCount(4, $categories);
            $this->assertEquals('All Requests', $categories['']);
            $this->assertEquals('Web Only', $categories['web']);
            $this->assertEquals('API Only', $categories['api']);
            $this->assertEquals('Mobile Only', $categories['mobile']);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_get_layout_configuration(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            config([
                'request-analytics.dashboard.layout' => [
                    'metrics_grid_columns' => 4,
                    'charts_grid_columns' => 2,
                    'analytics_grid_columns' => 2,
                    'responsive_breakpoints' => [
                        'sm' => 640,
                        'md' => 768,
                        'lg' => 1024,
                    ],
                ],
            ]);

            $page = new $analyticsDashboardClass();
            $layoutConfig = $page->getLayoutConfig();

            $this->assertIsArray($layoutConfig);
            $this->assertEquals(4, $layoutConfig['metrics_grid_columns']);
            $this->assertEquals(2, $layoutConfig['charts_grid_columns']);
            $this->assertEquals(2, $layoutConfig['analytics_grid_columns']);
            $this->assertArrayHasKey('responsive_breakpoints', $layoutConfig);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_handles_empty_configuration_gracefully(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            // Clear all configuration
            config(['request-analytics.dashboard' => []]);

            $page = new $analyticsDashboardClass();

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

    #[Test]
    public function it_can_mount_with_request_parameters(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            // Mock request parameters
            request()->merge([
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-31',
                'request_category' => 'api',
            ]);

            config(['request-analytics.dashboard.defaults.request_category' => 'web']);

            $page = new $analyticsDashboardClass();
            $page->mount();

            $this->assertEquals('2024-01-01', $page->startDate);
            $this->assertEquals('2024-01-31', $page->endDate);
            $this->assertEquals('api', $page->requestCategory);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_uses_default_values_when_request_parameters_are_missing(): void
    {
        $analyticsDashboardClass = 'Meshaon\FilamentRequestAnalytics\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            // Clear request parameters
            request()->replace([]);

            config([
                'request-analytics.dashboard.defaults.request_category' => 'web',
            ]);

            $page = new $analyticsDashboardClass();
            $page->mount();

            $this->assertEquals('', $page->startDate);
            $this->assertEquals('', $page->endDate);
            $this->assertEquals('web', $page->requestCategory);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }
}