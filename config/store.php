<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Brand identity (placeholder)
    |--------------------------------------------------------------------------
    |
    | PRODUCT.md records that the real brand name is not settled. Everything
    | here is placeholder copy: set the STORE_* values in .env when the real
    | identity lands, and never treat "BrandName" as the actual brand.
    |
    */
    'name' => env('STORE_NAME', 'BrandName'),

    'handle' => env('STORE_HANDLE', '@brandname_official'),

    /*
    |--------------------------------------------------------------------------
    | Preview disclosure
    |--------------------------------------------------------------------------
    |
    | While the catalogue, prices and photography are illustrative, the site
    | says so out loud. Turning this off is a deliberate act: it is the only
    | thing standing between placeholder content and a visitor reading it as
    | fact (PRODUCT.md, Evidence on Hand).
    |
    */
    'preview' => (bool) env('STORE_PREVIEW', true),

    /*
    |--------------------------------------------------------------------------
    | Commerce
    |--------------------------------------------------------------------------
    |
    | Market is Ghana; prices are quoted in cedis. Orders currently close in a
    | WhatsApp conversation because no payment provider exists yet.
    |
    */
    'currency' => [
        'code' => 'GHS',
        'symbol' => 'GH₵',
    ],

    'whatsapp' => env('STORE_WHATSAPP', '233000000000'),

    'delivery' => [
        'areas' => [
            'Accra — same day',
            'Accra — next day',
            'Tema / Greater Accra',
            'Kumasi',
            'Other region (courier)',
        ],
    ],
];
