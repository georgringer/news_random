<?php

declare(strict_types=1);

namespace GeorgRinger\NewsRandom\EventListener;

/**
 * This file is part of the "news_random" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use GeorgRinger\News\Event\CreateDemandObjectFromSettingsEvent;


final class NewsDemandListener
{
    public function __invoke(CreateDemandObjectFromSettingsEvent $event): void
    {
        $demand = $event->getDemand();
        if (!$demand instanceof NewsDemand) {
            return;
        }

        $customSettings = (array)$demand->getCustomSettings();
        $customSettings['news_random']['enabled'] = (bool)($event->getSettings()['randomNews'] ?? false);
        $demand->setCustomSettings($customSettings);
    }
}
