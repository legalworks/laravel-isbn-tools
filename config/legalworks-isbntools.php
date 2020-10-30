<?php

return [
    'default_client' => 'beck-shop',

    'clients' => [
        'openlibrary' => [],
        'DnbSru' => [
            'url' => env('ISBN_DNBSRU_URL', "https://services.dnb.de/sru/dnb"),
            'token' => env('ISBN_DNBSRU_TOKEN'),
        ],
    ]
];
