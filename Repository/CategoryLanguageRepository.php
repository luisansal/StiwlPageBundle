<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Category_LanguageRepository
 *
 */
class CategoryLanguageRepository extends EntityRepository {

    public function findAllFilterToSonataAdmin_language($language) {
        $qb = $this->createQueryBuilder('categoryLanguage');
        $qb->where($qb->expr()->eq('categoryLanguage.language', ':language'))
                ->setParameter('language', $language)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

}
