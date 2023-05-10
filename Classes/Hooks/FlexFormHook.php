<?php

declare(strict_types=1);

namespace GeorgRinger\NewsRandom\Hooks;

/**
 * This file is part of the "news_random" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FlexFormHook
{
    public function parseDataStructureByIdentifierPostProcess(array $dataStructure, array $identifier): array
    {
        if ($identifier['type'] === 'tca' && $identifier['tableName'] === 'tt_content' && $identifier['dataStructureKey'] === '*,news_pi1') {
            $file = ExtensionManagementUtility::extPath('news_random') . 'Configuration/Flexforms/flexform_news_random.xml';
            $content = file_get_contents($file);
            if ($content) {
                $dataStructure['sheets']['extraEntryNewsRandom'] = GeneralUtility::xml2array($content);
            }
        }
        return $dataStructure;
    }
}