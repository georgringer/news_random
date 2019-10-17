<?php

namespace GeorgRinger\NewsRandom\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class FlexFormHook
{
    /**
     * @param array $dataStructure
     * @param array $identifier
     * @return array
     */
    public function parseDataStructureByIdentifierPostProcess(array $dataStructure, array $identifier)
    {
        if ($identifier['type'] === 'tca' && $identifier['tableName'] === 'tt_content' && $identifier['dataStructureKey'] === 'news_pi1,list') {
            $file = PATH_site . 'typo3conf/ext/news_random/Configuration/Flexforms/flexform_news_random.xml';
            $content = file_get_contents($file);
            if ($content) {
                $dataStructure['sheets']['extraEntryNewsRandom'] = GeneralUtility::xml2array($content);
            }
        }
        return $dataStructure;
    }
}
