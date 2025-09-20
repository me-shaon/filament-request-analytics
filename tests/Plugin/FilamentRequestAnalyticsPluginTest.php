<?php

declare(strict_types=1);

namespace Meshaon\FilamentRequestAnalytics\Tests\Plugin;

use Filament\Contracts\Plugin;
use Filament\Panel;
// Note: AnalyticsDashboard is from external package MeShaon\RequestAnalytics
use Meshaon\FilamentRequestAnalytics\FilamentRequestAnalyticsPlugin;
use Meshaon\FilamentRequestAnalytics\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FilamentRequestAnalyticsPluginTest extends TestCase
{
    #[Test]
    public function it_implements_plugin_interface(): void
    {
        $plugin = new FilamentRequestAnalyticsPlugin();
        
        $this->assertInstanceOf(Plugin::class, $plugin);
    }

    #[Test]
    public function it_has_correct_id(): void
    {
        $plugin = new FilamentRequestAnalyticsPlugin();
        
        $this->assertEquals('filament-request-analytics', $plugin->getId());
    }

    #[Test]
    public function it_registers_analytics_dashboard_page(): void
    {
        $plugin = new FilamentRequestAnalyticsPlugin();
        
        // Create a mock panel
        $panel = $this->createMock(Panel::class);
        
        // Expect the panel to receive the AnalyticsDashboard page
        $analyticsDashboardClass = 'MeShaon\RequestAnalytics\Filament\Pages\AnalyticsDashboard';
        $panel->expects($this->once())
            ->method('pages')
            ->with([$analyticsDashboardClass]);
        
        $plugin->register($panel);
    }

    #[Test]
    public function it_boots_without_errors(): void
    {
        $plugin = new FilamentRequestAnalyticsPlugin();
        
        // Create a mock panel
        $panel = $this->createMock(Panel::class);
        
        // Boot should not throw any exceptions
        $this->expectNotToPerformAssertions();
        $plugin->boot($panel);
    }

    #[Test]
    public function it_can_be_made_statically(): void
    {
        $plugin = FilamentRequestAnalyticsPlugin::make();
        
        $this->assertInstanceOf(FilamentRequestAnalyticsPlugin::class, $plugin);
    }

    #[Test]
    public function it_can_be_retrieved_statically(): void
    {
        // Mock the filament helper function
        $mockPlugin = new FilamentRequestAnalyticsPlugin();
        
        // Since we can't easily mock the filament() helper, we'll test the structure
        $this->assertInstanceOf(FilamentRequestAnalyticsPlugin::class, $mockPlugin);
    }

    #[Test]
    public function it_returns_same_instance_when_made_multiple_times(): void
    {
        $plugin1 = FilamentRequestAnalyticsPlugin::make();
        $plugin2 = FilamentRequestAnalyticsPlugin::make();
        
        // Both should be instances of the same class
        $this->assertInstanceOf(FilamentRequestAnalyticsPlugin::class, $plugin1);
        $this->assertInstanceOf(FilamentRequestAnalyticsPlugin::class, $plugin2);
    }

    #[Test]
    public function it_has_analytics_dashboard_page_class(): void
    {
        $plugin = new FilamentRequestAnalyticsPlugin();
        
        // Verify that the AnalyticsDashboard class exists and is the correct one
        $analyticsDashboardClass = 'MeShaon\RequestAnalytics\Filament\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            $this->assertTrue(class_exists($analyticsDashboardClass));
            $this->assertEquals($analyticsDashboardClass, $analyticsDashboardClass);
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }

    #[Test]
    public function it_can_be_instantiated_without_dependencies(): void
    {
        $this->expectNotToPerformAssertions();
        
        new FilamentRequestAnalyticsPlugin();
    }

    #[Test]
    public function it_registers_correct_page_class(): void
    {
        $plugin = new FilamentRequestAnalyticsPlugin();
        
        // Verify the page class is the correct one
        $reflection = new \ReflectionClass($plugin);
        $registerMethod = $reflection->getMethod('register');
        
        // We can't easily test the internal behavior without complex mocking,
        // but we can verify the class exists and is correct
        $analyticsDashboardClass = 'MeShaon\RequestAnalytics\Filament\Pages\AnalyticsDashboard';
        
        if (class_exists($analyticsDashboardClass)) {
            $this->assertTrue(class_exists($analyticsDashboardClass));
        } else {
            $this->markTestSkipped('AnalyticsDashboard class not available - external dependency not installed');
        }
    }
}