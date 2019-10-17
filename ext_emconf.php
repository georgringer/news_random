<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Random news',
    'description' => 'Display random news',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'mail@ringer.it',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.13-9.5.99',
            'news' => '6.0.0-9.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
