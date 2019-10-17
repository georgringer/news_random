<?php

namespace GeorgRinger\NewsRandom\Hooks;

use GeorgRinger\News\Domain\Model\DemandInterface;
use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NewsRepositoryHook
{

    static $count = 0;


    /**
     * Modify the constraints used in the query
     *
     * @param array $params
     * @return void
     */
    public function modify(array $params, $fo)
    {
        /** @var NewsDemand $demand */
        $demand = $params['demand'];
        $limit = $demand->getLimit();
        $customSettings = $demand->getCustomSettings();

        if (self::$count === 0 && $limit > 0
            && isset($customSettings['news_random']) && $customSettings['news_random']['enabled']
        ) {
            self::$count++;
            /** @var NewsRepository $fo */
            $sql = $fo->findDemandedRaw($params['demand']);
            $sql = $this->stripOrderBy($sql);
            $sql .= ' ORDER BY RAND() LIMIT ' . $limit;

            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_news_domain_model_news');
            $res = $connection->query($sql);
            $idList = [];
            while ($row = $res->fetch()) {
                $idList[] = $row['uid'];
            }

            if (!empty($idList)) {
                $this->updateEventConstraints(
                    $params['demand'],
                    $params['respectEnableFields'],
                    $params['query'],
                    $params['constraints'],
                    $idList
                );
            }
        }
    }

    /**
     * Update the main event constraints
     *
     * @param DemandInterface $demand
     * @param bool $respectEnableFields
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $constraints
     * @param array $idList
     * @return void
     */
    protected function updateEventConstraints(
        DemandInterface $demand,
        $respectEnableFields,
        \TYPO3\CMS\Extbase\Persistence\QueryInterface $query,
        array &$constraints,
        array $idList
    )
    {
        $constraints['news_random-idlist'] = $query->in('uid', $idList);
    }

    /**
     * Return stripped order sql
     *
     * @param string $str
     * @return string
     */
    private function stripOrderBy(string $str)
    {
        return preg_replace('/(?:ORDER[[:space:]]*BY[[:space:]]*.*)+/i', '', trim($str));
    }

}
