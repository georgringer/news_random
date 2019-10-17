<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools::class]['flexParsing'][]
    = \GeorgRinger\NewsRandom\Hooks\FlexFormHook::class;

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['news_random']
    = \GeorgRinger\NewsRandom\Hooks\NewsRepositoryHook::class . '->modify';

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Controller/NewsController.php']['createDemandObjectFromSettings']['news_random']
    = \GeorgRinger\NewsRandom\Hooks\SettingsHook::class . '->modify';
