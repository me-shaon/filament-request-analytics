<?php

namespace Meshaon\FilamentRequestAnalytics\Commands;

use Illuminate\Console\Command;

class FilamentRequestAnalyticsCommand extends Command
{
    public $signature = 'filament-request-analytics';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
