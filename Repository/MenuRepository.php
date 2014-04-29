<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MenuRepository
 *
 * This class contains the menu's repository dql.
 */
class MenuRepository extends EntityRepository {

    /**
     * Find all menus, but no repeat depending language and menu id
     * @param string $language
     * @param integer $menuId
     * @return mixed
     */
    public function findAllNoRepeatedInPage_language_id($language, $menuId = null) {
        $qb = $this->createQueryBuilder('menu');
        $qb->addSelect('languages')
                ->join('menu.languages', 'languages')
                ->where('languages.language = :language')
        ;
        if ($menuId) {
            $qb->andWhere('menu.id NOT IN (SELECT page_menu.id FROM StiwlPageBundle:Page page join page.menu page_menu where page_menu.id != :menuId)')
                    ->setParameter('menuId', $menuId);
        } else {
            $qb->andWhere('menu.id NOT IN (SELECT page_menu.id FROM StiwlPageBundle:Page page join page.menu page_menu)');
        }
        $qb->setParameter('language', $language);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * Create query to sonata, find all menus depending language
     * @param query $query
     * @param string $language
     * @return query
     */
    public function findAllToSonataAdmin_query_language($query, $language) {
//        $qb = $this->getEntityManager()->createQueryBuilder();
        $query->addSelect('languages')
                ->join('o.languages', 'languages')
                ->where('languages.language = :language')
                ->setParameter(':language', $language)
        ;
        return $query;
    }

    /**
     * Find one menu if is parent, add a join from the same parent
     * @param integer $id
     * @param language $language
     * @param boolean $default
     * @param boolean $parent
     * @return mixd
     */
    public function findOne_id_language_default_parent($id, $language, $default = true, $parent = null) {
        $qb = $this->createQueryBuilder('menu');
        if ($default) {
            $qb->addSelect('languages')
                    ->join('menu.languages', 'languages')
                    ->where('languages.language = :language')
                    ->andWhere('menu.id = :id')
                    ->orderBy('menu.position', 'asc')
            ;
        } else {
            if ($parent) {
                $qb->addSelect('parent', 'parent_languages', 'languages')
                        ->join('menu.parent', 'parent')
                        ->join('parent.languages', 'parent_languages')
                        ->join('menu.languages', 'languages')
                        ->where('languages.language = :language')
                        ->andWhere('menu.id = :id')
                        ->andWhere('parent_languages.language = :language')
                        ->orderBy('menu.position', 'asc')
                ;
            } else {
                $qb->addSelect('languages')
                        ->join('menu.languages', 'languages')
                        ->where('languages.language = :language')
                        ->andWhere('menu.id = :id')
                        ->orderBy('menu.position', 'asc')
                ;
            }
        }
        $qb->setParameter('language', $language)
                ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * Find all, but not depending menu id and language
     * @param string $language
     * @param integer $menuId
     * @return mixed
     */
    public function findAllNotSelf_language_id($language, $menuId = null) {
        $qb = $this->createQueryBuilder('menu');
        $qb->addSelect('languages')
                ->join('menu.languages', 'languages')
                ->where('languages.language = :language')
                ->setParameter('language', $language)
                ->orderBy('menu.position', 'asc')
        ;
        if ($menuId) {
            $qb->andWhere('menu.id NOT IN (SELECT menu2.id FROM StiwlPageBundle:Menu menu2 where menu2.id = :menuId)')
                    ->setParameter('menuId', $menuId);
        }
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * Find all ordered depending language
     * @param string $language
     * @return mixed
     */
    public function findAllOrdered_language($language) {
        $qb = $this->createQueryBuilder('menu');
        $qb->addSelect('languages', 'parent', 'parent_languages')
                ->leftJoin('menu.parent', 'parent')
                ->leftJoin('parent.languages', 'parent_languages')
                ->join('menu.languages', 'languages')
                ->where('languages.language = :language')
                ->orWhere('parent_languages.language = :language')
                ->setParameter('language', $language)
                ->orderBy('menu.position', 'asc');
        $query = $qb->getQuery();
        return $query->getResult();
    }

}
