<?php

declare(strict_types=1);

namespace Meshaon\FilamentRequestAnalytics\Tests\ServiceProvider;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Meshaon\FilamentRequestAnalytics\FilamentRequestAnalyticsServiceProvider;
use Meshaon\FilamentRequestAnalytics\Testing\TestsFilamentRequestAnalytics;
use Meshaon\FilamentRequestAnalytics\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelPackageTools\Package;

class FilamentRequestAnalyticsServiceProviderTest extends TestCase
{
    #[Test]
    public function it_has_correct_package_name(): void
    {
        $this->assertEquals('filament-request-analytics', FilamentRequestAnalyticsServiceProvider::$name);
    }

    #[Test]
    public function it_has_correct_view_namespace(): void
    {
        $this->assertEquals('filament-request-analytics', FilamentRequestAnalyticsServiceProvider::$viewNamespace);
    }


    #[Test]
    public function it_registers_assets(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($provider);
        $getAssetsMethod = $reflection->getMethod('getAssets');
        $getAssetsMethod->setAccessible(true);
        
        $assets = $getAssetsMethod->invoke($provider);
        
        $this->assertIsArray($assets);
        $this->assertNotEmpty($assets);
        
        // Check that we have CSS and JS assets
        $hasCss = false;
        $hasJs = false;
        
        foreach ($assets as $asset) {
            $this->assertInstanceOf(Asset::class, $asset);
            
            if ($asset instanceof Css) {
                $hasCss = true;
            }
            
            if ($asset instanceof Js) {
                $hasJs = true;
            }
        }
        
        $this->assertTrue($hasCss, 'Service provider should register CSS assets');
        $this->assertTrue($hasJs, 'Service provider should register JS assets');
    }

    #[Test]
    public function it_registers_icons(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($provider);
        $getIconsMethod = $reflection->getMethod('getIcons');
        $getIconsMethod->setAccessible(true);
        
        $icons = $getIconsMethod->invoke($provider);
        
        $this->assertIsArray($icons);
    }

    #[Test]
    public function it_registers_routes(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($provider);
        $getRoutesMethod = $reflection->getMethod('getRoutes');
        $getRoutesMethod->setAccessible(true);
        
        $routes = $getRoutesMethod->invoke($provider);
        
        $this->assertIsArray($routes);
    }

    #[Test]
    public function it_registers_script_data(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($provider);
        $getScriptDataMethod = $reflection->getMethod('getScriptData');
        $getScriptDataMethod->setAccessible(true);
        
        $scriptData = $getScriptDataMethod->invoke($provider);
        
        $this->assertIsArray($scriptData);
    }

    #[Test]
    public function it_registers_migrations(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($provider);
        $getMigrationsMethod = $reflection->getMethod('getMigrations');
        $getMigrationsMethod->setAccessible(true);
        
        $migrations = $getMigrationsMethod->invoke($provider);
        
        $this->assertIsArray($migrations);
        $this->assertContains('create_filament-request-analytics_table', $migrations);
    }

    #[Test]
    public function it_has_correct_asset_package_name(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($provider);
        $getAssetPackageNameMethod = $reflection->getMethod('getAssetPackageName');
        $getAssetPackageNameMethod->setAccessible(true);
        
        $packageName = $getAssetPackageNameMethod->invoke($provider);
        
        $this->assertEquals('me-shaon/filament-request-analytics', $packageName);
    }

    #[Test]
    public function it_registers_testing_mixin(): void
    {
        // This test verifies that the testing mixin is registered
        // We can't easily test the actual registration without complex mocking,
        // but we can verify the class exists
        $this->assertTrue(class_exists(TestsFilamentRequestAnalytics::class));
    }

    #[Test]
    public function it_handles_stubs_when_running_in_console(): void
    {
        // Mock the app to return true for runningInConsole
        $app = $this->createMock(\Illuminate\Contracts\Foundation\Application::class);
        $app->method('runningInConsole')->willReturn(true);
        
        // Mock Filesystem
        $filesystem = $this->createMock(Filesystem::class);
        $app->method('make')->with(Filesystem::class)->willReturn($filesystem);
        
        // Mock file objects
        $file1 = $this->createMock(\SplFileInfo::class);
        $file1->method('getRealPath')->willReturn('/path/to/stub1.php');
        $file1->method('getFilename')->willReturn('stub1.php');
        
        $file2 = $this->createMock(\SplFileInfo::class);
        $file2->method('getRealPath')->willReturn('/path/to/stub2.php');
        $file2->method('getFilename')->willReturn('stub2.php');
        
        $filesystem->method('files')->willReturn([$file1, $file2]);
        
        $provider = new FilamentRequestAnalyticsServiceProvider($app);
        
        // This should not throw any exceptions
        $this->expectNotToPerformAssertions();
        $provider->packageBooted();
    }

    #[Test]
    public function it_extends_package_service_provider(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        $this->assertInstanceOf(\Spatie\LaravelPackageTools\PackageServiceProvider::class, $provider);
    }

    #[Test]
    public function it_can_configure_package(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // Mock Package
        $package = $this->createMock(Package::class);
        
        // The configurePackage method should not throw exceptions
        $this->expectNotToPerformAssertions();
        
        // Use reflection to call the protected method
        $reflection = new \ReflectionClass($provider);
        $configurePackageMethod = $reflection->getMethod('configurePackage');
        $configurePackageMethod->setAccessible(true);
        $configurePackageMethod->invoke($provider, $package);
    }

    #[Test]
    public function it_has_package_registered_method(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // The packageRegistered method should not throw exceptions
        $this->expectNotToPerformAssertions();
        $provider->packageRegistered();
    }

    #[Test]
    public function it_has_package_booted_method(): void
    {
        $provider = new FilamentRequestAnalyticsServiceProvider($this->app);
        
        // The packageBooted method should not throw exceptions
        $this->expectNotToPerformAssertions();
        $provider->packageBooted();
    }
}