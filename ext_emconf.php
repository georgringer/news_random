<?php

$EM_CONF['news_random'] = [
    'title' => 'Random news',
    'description' => 'Display random news',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'mail@ringer.it',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.4.99',
            'typo3' => '13.4.0-13.4.99',
            'news' => '12.2.0-14.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
