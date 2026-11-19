<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [

    'newsrandom-svg' => [

        'provider' => SvgIconProvider::class,
        'source' => 'EXT:news_random/Resources/Public/Icons/Extension.svg',
    ],
];