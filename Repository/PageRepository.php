<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class contains the page's repository dql.
 */
class PageRepository extends EntityRepository {

    /**
     * Create query to sonata, find all pages depending language
     * @param query $query
     * @param string $language
     * @return query
     */
    public function findAllToSonataAdmin_query_language($query, $language) {
//        $qb = $this->createQueryBuilder('page');
        $query->addSelect('menu', 'menu_languages', 'languages')
                ->join('o.menu', 'menu')
                ->join('menu.languages', 'menu_languages')
                ->join('o.languages', 'languages')
                ->where('languages.language = :language')
                ->andWhere('menu_languages.language = :language')
                ->setParameter('language', $language)
        ;
        return $query;
    }

    /**
     * Find one page depending id and language
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function findOne_id_language($id, $language) {
        $qb = $this->createQueryBuilder('page');
        $qb->addSelect('menu', 'menu_languages', 'languages')
                ->join('page.menu', 'menu')
                ->join('menu.languages', 'menu_languages')
                ->join('page.languages', 'languages')
                ->where('page.id = :id')
                ->andWhere('languages.language = :language')
                ->andWhere('menu_languages.language = :language')
                ->setParameter('language', $language)
                ->setParameter('id', $id)
        ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * Find the page depending the menu
     * @param integer $menuId
     * @param string $language
     * @return mixed
     */
    public function findOne_menuId_language($menuId, $language) {
        $qb = $this->createQueryBuilder('page');
        $qb->addSelect('menu', 'menu_languages', 'languages')
                ->join('page.menu', 'menu')
                ->join('menu.languages', 'menu_languages')
                ->join('page.languages', 'languages')
                ->where('menu.id = :menuId')
                ->andWhere('languages.language = :language')
                ->andWhere('menu_languages.language = :language')
                ->setParameter('language', $language)
                ->setParameter('menuId', $menuId)
        ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

}
