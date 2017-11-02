<?php

return [

    // The default gateway to use
    'default' => 'stripe',

    // Add in each gateway here
    'gateways' => [
        'paypal' => [
            'driver'  => 'PayPal_Express',
            'options' => [
                'solutionType'   => '',
                'landingPage'    => '',
                'headerImageUrl' => '',
            ],
        ],
        'stripe' => [
            'driver'  => 'Stripe',
            'options' => [],
        ],
        'scellius' => [
            'driver' => 'Scellius',
            'options' => [
              'merchantId'=> '',
              'merchantCountry'=> '',
              'pathBinRequest'=> '',
              'pathBinResponse'=> '',
              'pathFile'=> '',
            ],
        ],
    ],

];
