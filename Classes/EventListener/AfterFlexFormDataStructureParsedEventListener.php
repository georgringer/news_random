<?php

declare(strict_types=1);

namespace GeorgRinger\NewsRandom\EventListener;

/**
 * This file is part of the "news_random" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;


final class AfterFlexFormDataStructureParsedEventListener
{
    private const DATA_STRUCTURE_KEY = '*,news_pi1';
    private const SHEET_NAME = 'extraEntryNewsRandom';

    public function __invoke(AfterFlexFormDataStructureParsedEvent $event): void
    {
        $identifier = $event->getIdentifier();
        if (($identifier['type'] ?? '') !== 'tca'
            || ($identifier['tableName'] ?? '') !== 'tt_content'
            || ($identifier['dataStructureKey'] ?? '') !== self::DATA_STRUCTURE_KEY
        ) {
            return;
        }

        $file = ExtensionManagementUtility::extPath('news_random') . 'Configuration/FlexForms/flexform_news_random.xml';
        $content = file_get_contents($file);
        if ($content === false || $content === '') {
            return;
        }

        $sheet = GeneralUtility::xml2array($content);
        if (!is_array($sheet)) {
            return;
        }

        $dataStructure = $event->getDataStructure();
        $dataStructure['sheets'][self::SHEET_NAME] = $sheet;
        $event->setDataStructure($dataStructure);
    }
}
