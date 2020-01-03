<?php
 $title = "M&M Store online shopping made easy in Nigeria";
 $keywords = "'Polo Tops', 'Men\’s Shirts', 'Female Shirts', 'Jeans', 'Chinos', 'Track Suits', 'Joggers', 'Shorts', 'T-Shirts', 'Mobile Phones Accessories', 'Mobile phone chargers', 'Power Banks'. 'TVs', 'Home Theater'";
 $description = "Shop online for your fashion items, computer, phone and accessories, household appliances and electronics? Health and Beauty, Baby products and lots more. Quality Guaranteed.";

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => $title, // set false to total remove
            'description'  =>  $description, // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [$keywords],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'        => $title, // set false to total remove
            'description'  =>  env('APP_DESC'), // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => env('APP_NAME'),
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
