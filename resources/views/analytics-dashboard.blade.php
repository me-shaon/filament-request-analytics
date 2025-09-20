<x-filament-panels::page>
    <!-- Header with Filters -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex-1">
                <p class="text-sm text-gray-500 dark:text-gray-400">Track your website performance and user insights</p>
            </div>
            <div class="flex-shrink-0">
                <form method="GET" action="{{ request()->url() }}" class="flex items-center gap-3">
                    <x-request-analytics::core.calendar-filter 
                        :dateRange="$dateRange" 
                        :startDate="request('start_date')"
                        :endDate="request('end_date')"
                    />
                    <select name="request_category" class="block w-auto min-w-[140px] rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="" {{ !request('request_category') ? 'selected' : '' }}>All Requests</option>
                        <option value="web" {{ request('request_category') == 'web' ? 'selected' : '' }}>Web Only</option>
                        <option value="api" {{ request('request_category') == 'api' ? 'selected' : '' }}>API Only</option>
                    </select>
                    <x-filament::button type="submit" size="sm">
                        Apply Filters
                    </x-filament::button>
                </form>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards - Force 4 Column Grid -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        @php
            $metricsCards = [
                ['label' => 'Views', 'value' => $average['views']],
                ['label' => 'Visitors', 'value' => $average['visitors']],
                ['label' => 'Bounce Rate', 'value' => $average['bounce_rate']],
                ['label' => 'Average Visit Time', 'value' => $average['average_visit_time']]
            ];
        @endphp
        
        @foreach($metricsCards as $card)
            <x-filament::section class="text-center">
                <x-request-analytics::stats.count label="{{ $card['label'] }}" :value="$card['value']"/>
            </x-filament::section>
        @endforeach
    </div>

    <!-- Chart Section -->
    <div class="mb-6">
        <x-filament::section>
            <x-slot name="heading">
                Traffic Overview
            </x-slot>
            <x-slot name="description">
                Daily visitor and page view trends
            </x-slot>
            
            <div class="mt-6">
                <x-request-analytics::stats.chart :labels='$labels' :datasets='$datasets' type="line"/>
            </div>
        </x-filament::section>
    </div>

    <!-- Pages and Referrers - Force 2 Column Grid -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        <x-filament::section>
            <x-request-analytics::analytics.pages :pages='$pages'/>
        </x-filament::section>
        <x-filament::section>
            <x-request-analytics::analytics.referrers :referrers='$referrers'/>
        </x-filament::section>
    </div>

    <!-- Browsers, OS, Devices, Countries - Force 2 Column Grid -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        <x-filament::section>
            <x-request-analytics::analytics.broswers :browsers='$browsers'/>
        </x-filament::section>
        <x-filament::section>
            <x-request-analytics::analytics.operating-systems :operatingSystems='$operatingSystems'/>
        </x-filament::section>
        <x-filament::section>
            <x-request-analytics::analytics.devices :devices='$devices'/>
        </x-filament::section>
        <x-filament::section>
            <x-request-analytics::analytics.countries :countries='$countries'/>
        </x-filament::section>
    </div>
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