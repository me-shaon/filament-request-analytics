<x-filament-panels::page>
    <!-- Header with Filters -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex-1">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $this->getConfig('page.description', 'Track your website performance and user insights') }}</p>
            </div>
            <div class="flex-shrink-0">
                <form method="GET" action="{{ request()->url() }}" class="flex items-center gap-3">
                    <x-request-analytics::core.calendar-filter 
                        :dateRange="$dateRange" 
                        :startDate="request('start_date')"
                        :endDate="request('end_date')"
                    />
                    <select name="request_category" class="block w-auto min-w-[140px] rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @foreach($this->getRequestCategories() as $value => $label)
                            <option value="{{ $value }}" {{ request('request_category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-filament::button type="submit" size="sm">
                        Apply Filters
                    </x-filament::button>
                </form>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards - Configurable Grid -->
    @php
        $metricsGridColumns = $this->getConfig('layout.metrics_grid_columns', 4);
        $enabledMetrics = $this->getEnabledMetrics();
    @endphp
    
    @if(count($enabledMetrics) > 0)
    <div style="display: grid; grid-template-columns: repeat({{ $metricsGridColumns }}, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        @foreach($enabledMetrics as $key => $metric)
            @if(isset($average[$key]))
                <x-filament::section class="text-center">
                    <x-request-analytics::stats.count label="{{ $metric['label'] }}" :value="$average[$key]"/>
                </x-filament::section>
            @endif
        @endforeach
    </div>
    @endif

    <!-- Chart Section -->
    @php
        $chartsConfig = $this->getChartsConfig();
    @endphp
    
    @foreach($chartsConfig as $chartKey => $chartConfig)
        @if($chartKey === 'traffic_overview')
            <div class="mb-6">
                <x-filament::section>
                    <x-slot name="heading">
                        {{ $chartConfig['title'] ?? 'Traffic Overview' }}
                    </x-slot>
                    <x-slot name="description">
                        {{ $chartConfig['description'] ?? 'Daily visitor and page view trends' }}
                    </x-slot>
                    
                    <div class="mt-6">
                        <x-request-analytics::stats.chart :labels='$labels' :datasets='$datasets' type="{{ $chartConfig['type'] ?? 'line' }}"/>
                    </div>
                </x-filament::section>
            </div>
        @endif
    @endforeach

    <!-- Pages and Referrers - Configurable Grid -->
    @php
        $chartsGridColumns = $this->getConfig('layout.charts_grid_columns', 2);
        $enabledSections = $this->getEnabledSections();
        $topSections = array_filter($enabledSections, fn($key) => in_array($key, ['pages', 'referrers']), ARRAY_FILTER_USE_KEY);
    @endphp
    
    @if(count($topSections) > 0)
    <div style="display: grid; grid-template-columns: repeat({{ $chartsGridColumns }}, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        @if(isset($enabledSections['pages']) && isset($pages))
            <x-filament::section>
                <x-slot name="heading">{{ $enabledSections['pages']['title'] ?? 'Top Pages' }}</x-slot>
                <x-request-analytics::analytics.pages :pages='$pages'/>
            </x-filament::section>
        @endif
        @if(isset($enabledSections['referrers']) && isset($referrers))
            <x-filament::section>
                <x-slot name="heading">{{ $enabledSections['referrers']['title'] ?? 'Top Referrers' }}</x-slot>
                <x-request-analytics::analytics.referrers :referrers='$referrers'/>
            </x-filament::section>
        @endif
    </div>
    @endif

    <!-- Browsers, OS, Devices, Countries - Configurable Grid -->
    @php
        $analyticsGridColumns = $this->getConfig('layout.analytics_grid_columns', 2);
        $bottomSections = array_filter($enabledSections, fn($key) => in_array($key, ['browsers', 'operating_systems', 'devices', 'countries']), ARRAY_FILTER_USE_KEY);
    @endphp
    
    @if(count($bottomSections) > 0)
    <div style="display: grid; grid-template-columns: repeat({{ $analyticsGridColumns }}, 1fr); gap: 1.5rem;">
        @if(isset($enabledSections['browsers']) && isset($browsers))
            <x-filament::section>
                <x-slot name="heading">{{ $enabledSections['browsers']['title'] ?? 'Browser Analytics' }}</x-slot>
                <x-request-analytics::analytics.broswers :browsers='$browsers'/>
            </x-filament::section>
        @endif
        @if(isset($enabledSections['operating_systems']) && isset($operatingSystems))
            <x-filament::section>
                <x-slot name="heading">{{ $enabledSections['operating_systems']['title'] ?? 'Operating Systems' }}</x-slot>
                <x-request-analytics::analytics.operating-systems :operatingSystems='$operatingSystems'/>
            </x-filament::section>
        @endif
        @if(isset($enabledSections['devices']) && isset($devices))
            <x-filament::section>
                <x-slot name="heading">{{ $enabledSections['devices']['title'] ?? 'Device Analytics' }}</x-slot>
                <x-request-analytics::analytics.devices :devices='$devices'/>
            </x-filament::section>
        @endif
        @if(isset($enabledSections['countries']) && isset($countries))
            <x-filament::section>
                <x-slot name="heading">{{ $enabledSections['countries']['title'] ?? 'Country Analytics' }}</x-slot>
                <x-request-analytics::analytics.countries :countries='$countries'/>
            </x-filament::section>
        @endif
    </div>
    @endif
    <!-- Ensure calendar Apply button uses Filament primary colors -->
    <style>
        /* Style calendar Apply button with Filament primary colors */
        [x-data*="calendarFilter"] button[class*="bg-blue-600"] {
            background-color: rgb(var(--primary-600)) !important;
            color: white !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            transition: background-color 150ms ease-in-out !important;
        }
        
        [x-data*="calendarFilter"] button[class*="bg-blue-600"]:hover {
            background-color: rgb(var(--primary-700)) !important;
        }
        
        /* Ensure both buttons are visible and properly styled */
        [x-data*="calendarFilter"] .flex.justify-end button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 70px !important;
        }
        
        /* Style Cancel button to match Filament */
        [x-data*="calendarFilter"] button[class*="text-gray-600"] {
            color: rgb(var(--gray-600)) !important;
            background-color: white !important;
            border: 1px solid rgb(var(--gray-300)) !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }
        
        [x-data*="calendarFilter"] button[class*="text-gray-600"]:hover {
            background-color: rgb(var(--gray-50)) !important;
        }
    </style>
</x-filament-panels::page>