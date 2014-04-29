<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class contains the news's repository dql.
 */
class NewsRepository extends EntityRepository {

    /**
     * Find one news depending id and language
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function findOne_id_language($id, $language) {
        $qb = $this->createQueryBuilder('news');
        $qb->addSelect('languages')
                ->join('news.languages', 'languages')
                ->where('languages.language = :language')
                ->andWhere('news.id = :id')
                ->setParameter('language', $language)
                ->setParameter('id', $id)
        ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * Find all news depending language
     * @param string $language
     * @return mixed
     */
    public function findAll_language($language) {
        $qb = $this->createQueryBuilder('news');
        $qb->addSelect('languages')
                ->join('news.languages', 'languages')
                ->where('languages.language = :language')
                ->orderBy('news.createdAt', 'desc')
                ->setParameter('language', $language)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * Create query to sonata, find all news depending language
     * @param query $query
     * @param string $language
     * @return query
     */
    public function findAllToSonataAdmin_query_language($query, $language) {
        $query->addSelect('languages')
                ->join('o.languages', 'languages')
                ->where('languages.language = :language')
                ->setParameter('language', $language)
        ;
        return $query;
    }

    /**
     * Not usable
     * @param string $language
     * @return mixed
     */
    public function findAllGroupDate_language($language) {
        $qb = $this->createQueryBuilder('news');
        $qb->addSelect('languages')
                ->join('news.languages', 'languages')
                ->where('languages.language = :language')
                ->groupBy('news.createdDateAt')
                ->orderBy('news.createdAt', 'desc')
                ->setParameter('language', $language)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * Not usable
     * @param date $date
     * @param string $language
     * @return mixed
     */
    public function findAll_date_language($date, $language) {
        $qb = $this->createQueryBuilder('news');
        $qb->addSelect('languages')
                ->join('news.languages', 'languages')
                ->where('languages.language = :language')
                ->andWhere('news.createdDateAt = :date')
                ->andWhere('news.status = :status')
                ->orderBy('news.createdAt', 'desc')
                ->setParameter('language', $language)
                ->setParameter('date', $date)
                ->setParameter('status', true)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

}
