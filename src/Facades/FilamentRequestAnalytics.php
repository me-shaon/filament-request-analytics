<?php

namespace Meshaon\FilamentRequestAnalytics\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Meshaon\FilamentRequestAnalytics\FilamentRequestAnalytics
 */
class FilamentRequestAnalytics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Meshaon\FilamentRequestAnalytics\FilamentRequestAnalytics::class;
    }
}
