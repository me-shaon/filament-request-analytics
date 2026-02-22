<?php

// config for Meshaon/FilamentRequestAnalytics
return [
    /*
    |--------------------------------------------------------------------------
    | Dashboard Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the Analytics Dashboard page appearance and behavior
    |
    */
    'dashboard' => [
        /*
        |--------------------------------------------------------------------------
        | Navigation Configuration
        |--------------------------------------------------------------------------
        */
        'navigation' => [
            'icon' => 'heroicon-o-chart-bar',
            'label' => 'Analytics',
            'sort' => 100,
            'group' => null,
        ],

        /*
        |--------------------------------------------------------------------------
        | Page Configuration
        |--------------------------------------------------------------------------
        */
        'page' => [
            'title' => 'Analytics Dashboard',
            'description' => 'Track your website performance and user insights',
        ],

        /*
        |--------------------------------------------------------------------------
        | Default Values
        |--------------------------------------------------------------------------
        */
        'defaults' => [
            'date_range' => 30, // days
            'request_category' => '', // empty for all requests
        ],

        /*
        |--------------------------------------------------------------------------
        | Layout Configuration
        |--------------------------------------------------------------------------
        */
        'layout' => [
            'metrics_grid_columns' => 4,
            'charts_grid_columns' => 2,
            'analytics_grid_columns' => 2,
        ],

        /*
        |--------------------------------------------------------------------------
        | Available Request Categories
        |--------------------------------------------------------------------------
        */
        'request_categories' => [
            '' => 'All Requests',
            'web' => 'Web Only',
            'api' => 'API Only',
        ],

        /*
        |--------------------------------------------------------------------------
        | Metrics Configuration
        |--------------------------------------------------------------------------
        */
        'metrics' => [
            'views' => [
                'label' => 'Views',
                'enabled' => true,
            ],
            'visitors' => [
                'label' => 'Visitors',
                'enabled' => true,
            ],
            'bounce_rate' => [
                'label' => 'Bounce Rate',
                'enabled' => true,
            ],
            'average_visit_time' => [
                'label' => 'Average Visit Time',
                'enabled' => true,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Chart Configuration
        |--------------------------------------------------------------------------
        */
        'charts' => [
            'traffic_overview' => [
                'title' => 'Traffic Overview',
                'description' => 'Daily visitor and page view trends',
                'type' => 'line',
                'enabled' => true,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Analytics Sections Configuration
        |--------------------------------------------------------------------------
        */
        'sections' => [
            'pages' => [
                'enabled' => true,
                'title' => 'Top Pages',
            ],
            'referrers' => [
                'enabled' => true,
                'title' => 'Top Referrers',
            ],
            'browsers' => [
                'enabled' => true,
                'title' => 'Browser Analytics',
            ],
            'operating_systems' => [
                'enabled' => true,
                'title' => 'Operating Systems',
            ],
            'devices' => [
                'enabled' => true,
                'title' => 'Device Analytics',
            ],
            'countries' => [
                'enabled' => true,
                'title' => 'Country Analytics',
            ],
        ],
    ],
];
