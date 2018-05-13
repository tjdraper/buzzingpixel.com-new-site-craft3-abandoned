<?php

return [
    'taxPercent' => 7,
    'taxState' => 'TN',
    'companyName' => 'BuzzingPixel, LLC',
    'companyAddress' => '1704 Carlyon Ct.',
    'companyCity' => 'Spring Hill',
    'companyStateProvince' => 'Tennessee',
    'companyStateProvinceShort' => 'TN',
    'companyPostalCode' => 37174,
    'companyCountry' => 'United States',
    'companyCountryShort' => 'U.S.A.',
    'orderEmailTemplate' => 'TODO',
    'orderEmailAdmin' => 'tj@buzzingpixel.com',
    'products' => [
        'ansel-craft' => [
            'title' => 'Ansel for CraftCMS',
            'url' => '/software/ansel-craft',
            'price' => 79,
            'versions' => [
                1 => null, // major version => upgrade price (use null for full price, 0 to auto update)
            ],
            'publicDownload' => true,
            'downloadFileLocations' => [
                1 => [
                    '1.0.7' => 'softwareDownloads/ansel-craft/ansel-craft-1.0.7.zip',
                ]
            ],
        ],
        'ansel-ee' => [
            'title' => 'Ansel for ExpressionEngine',
            'url' => '/software/ansel-ee',
            'price' => 79,
            'subscriptionPrice' => 29,
            'subscriptionFrequency' => 'yearly',
            'versions' => [
                1 => null,
                2 => 29, // major version => upgrade price (use null for full price, 0 to auto update)
            ],
            'publicDownload' => true,
            'downloadFileLocations' => [
                1 => [
                    '1.4.4' => 'softwareDownloads/ansel-ee/ansel-1.4.4.zip',
                ],
                2 => [
                    '2.1.4' => 'softwareDownloads/ansel-ee/ansel-2.1.4.zip',
                ],
            ],
        ],
        'treasury' => [
            'title' => 'Treasury',
            'url' => '/software/treasury',
            'price' => 79,
            'versions' => [
                1 => null,
            ],
            'publicDownload' => false,
            'downloadFileLocations' => [
                1 => [
                    '1.1.1' => 'softwareDownloads/treasury/treasury-1.1.1.zip',
                ],
            ],
        ],
        'ansel-treasury-ee' => [
            'title' => 'Ansel + Treasury',
            'url' => '/software/ansel-treasury-ee',
            'price' => 109,
            'versions' => [
                1 => null,
            ],
            'publicDownload' => false,
            'downloadFileLocations' => [
                1 => [
                    '2.1.4--1.1.1' => 'softwareDownloads/ansel-treasury-ee/ansel-2-1-4--treasury-1-1-1.zip',
                ],
            ],
            'isBundle' => true,
        ],
        'construct' => [
            'title' => 'Construct',
            'url' => '/software/construct',
            'price' => 40,
            'versions' => [
                1 => null,
                2 => null,
            ],
            'downloadFileLocations' => [
                2 => [
                    '2.1.0' => 'softwareDownloads/construct/construct-2.1.0.zip',
                ],
            ],
        ],
        'category-construct' => [
            'title' => 'Category Construct',
            'url' => '/software/category-construct',
            'price' => 15,
            'versions' => [
                1 => null,
                2 => null,
            ],
            'downloadFileLocations' => [
                2 => [
                    '2.2.0' => 'softwareDownloads/category-construct/category-construct-2.2.0.zip',
                ],
            ],
        ],
        'collective' => [
            'title' => 'Collective',
            'url' => '/software/collective',
            'price' => 18,
            'versions' => [
                1 => null,
                2 => null,
            ],
            'downloadFileLocations' => [
                2 => [
                    '2.2.1' => 'softwareDownloads/collective/collective-2.2.1.zip',
                ],
            ],
        ],
    ],
];
