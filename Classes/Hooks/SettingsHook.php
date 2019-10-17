<?php

namespace GeorgRinger\NewsRandom\Hooks;

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;

class SettingsHook
{
    /**
     * @param array $params
     * @return mixed
     */
    public function modify(array &$params)
    {
        /** @var NewsDemand $newsDemand */
        $newsDemand = $params['demand'];
        $settings = $params['settings'];

        $customSettings = $newsDemand->getCustomSettings();
        $customSettings['news_random']['enabled'] = (bool)$settings['randomNews'];
        $newsDemand->setCustomSettings($customSettings);
    }
}
