<?php

declare(strict_types=1);

namespace Meshaon\FilamentRequestAnalytics\Tests\Testing;

use Meshaon\FilamentRequestAnalytics\Testing\TestsFilamentRequestAnalytics;
use Meshaon\FilamentRequestAnalytics\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TestsFilamentRequestAnalyticsTest extends TestCase
{
    #[Test]
    public function it_can_be_instantiated(): void
    {
        $this->expectNotToPerformAssertions();
        
        new TestsFilamentRequestAnalytics();
    }

    #[Test]
    public function it_is_a_class(): void
    {
        $this->assertTrue(class_exists(TestsFilamentRequestAnalytics::class));
    }

    #[Test]
    public function it_provides_testing_methods(): void
    {
        // This test verifies that the class exists and can be used
        // The actual testing methods would be tested in integration tests
        $this->assertTrue(class_exists(TestsFilamentRequestAnalytics::class));
    }
}