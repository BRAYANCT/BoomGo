<?php

return [


    'use_sandbox' => env('SANDBOX_GATEWAYS', false),

    'mercadopago' => [
        'id'=> 1,

        'market_place_redirect_url'=> env('', 'https://boom-go.com/admin/mercado-pago/market-place-authorization'),


        'client_id' => env('ME_PAGO_CLIENT_ID', '1202966651115371'),
        'client_secret' => env('ME_PAGO_CLIENT_SECRET', 'h1AixkcjzrXG3mgbWGvdJdi3G79AFqmh'),

        'public_key' => env('ME_PAGO_PUBLIC_KEY', 'APP_USR-4d4b9abc-0a4a-43d7-95cd-e8180dcbfc53'),
        'access_token' => env('ME_PAGO_ACCES_TOKEN', 'APP_USR-1202966651115371-121420-ef9527287586f172485109bd976044f6-685040676'),

        'test_public_key'=> 'TEST-f7baa30a-ad3b-4d40-884a-f751d1ffa213',
        'test_access_token'=> 'TEST-1202966651115371-121420-e02f5a1650370d770b2070efb1077f1b-685040676',

        'test_email' => 'test_user_11439624@testuser.com',

    ],

    'upon_delivery'=>[
        'id'=>2
    ],

    'wire_transfer' => [
        'id'=> 3,
    ]

];
