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
use GeorgRinger\News\Event\ModifyDemandRepositoryEvent;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;


final class RandomizeNewsListener
{
    private const TABLE = 'tx_news_domain_model_news';

    public function __construct(
        private readonly Typo3DbQueryParser $queryParser,
    ) {}

    public function __invoke(ModifyDemandRepositoryEvent $event): void
    {
        $demand = $event->getDemand();
        if (!$demand instanceof NewsDemand) {
            return;
        }

        $limit = (int)$demand->getLimit();
        $customSettings = (array)$demand->getCustomSettings();
        if ($limit <= 0 || empty($customSettings['news_random']['enabled'])) {
            return;
        }

        $query = $event->getQuery();
        $constraints = $event->getConstraints();

        // Separate query: same constraints, but without ordering/limit/offset
        $uidQuery = clone $query;
        $uidQuery->setOrderings([]);
        if ($constraints !== []) {
            $uidQuery->matching($uidQuery->logicalAnd(...array_values($constraints)));
        }

        $uids = $this->queryParser
            ->convertQueryToDoctrineQueryBuilder($uidQuery)
            ->select(self::TABLE . '.uid')
            ->setFirstResult(0)
            ->setMaxResults(null)
            ->executeQuery()
            ->fetchFirstColumn();

        if ($uids === []) {
            return;
        }

        shuffle($uids);
        $uids = array_map(intval(...), array_slice($uids, 0, $limit));

        $constraints[] = $query->in('uid', $uids);
        $event->setConstraints($constraints);
    }
}
