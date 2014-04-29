<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class contains the product's repository dql.
 */
class ProductRepository extends EntityRepository {

    /**
     * Create query to sonata, find all products depending language
     * @param query $query
     * @param string $language
     * @return query
     */
    public function findAllToSonataAdmin_query_language($query, $language) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query->addSelect('category', 'category_languages', 'languages')
                ->join('o.category', 'category')
                ->join('category.languages', 'category_languages')
                ->join('o.languages', 'languages')
                ->where('languages.language = :language')
                ->andWhere('category_languages.language = :language')
                ->setParameter(':language', $language)
        ;
        return $query;
    }

    /**
     * Find all products latest depending limit and language
     * @param integer $limit
     * @param string $language
     * @return mixed
     */
    public function findAllNews_limit_language($limit, $language) {
        $qb = $this->createQueryBuilder('product');
        $qb->addSelect('languages')
                ->join('product.languages', 'languages')
                ->where('languages.language = :language')
                ->orderBy('product.createdAt', 'desc')
                ->setParameter('language', $language)
                ->setFirstResult(0)
                ->setMaxResults($limit)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * Find one product depending id and language
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function findOne_id_language($id, $language) {
        $qb = $this->createQueryBuilder('product');
        $qb->addSelect('category', 'category_languages', 'languages')
                ->join('product.category', 'category')
                ->join('category.languages', 'category_languages')
                ->join('product.languages', 'languages')
                ->where('languages.language = :language')
                ->andWhere('category_languages.language = :language')
                ->andWhere('product.id = :id')
                ->setParameter('language', $language)
                ->setParameter('id', $id)
        ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * Find all category depending categoryId and language
     * @param integer $categoryId
     * @param string $language
     * @return mixed
     */
    public function findAll_categoryId_language($categoryId, $language) {
        $qb = $this->createQueryBuilder('product');
        $qb->addSelect('category', 'category_languages', 'product_languages')
                ->join('product.category', 'category')
                ->join('category.languages', 'category_languages')
                ->join('product.languages', 'product_languages')
                ->where('category_languages.language = :language')
                ->andWhere('product_languages.language = :language')
                ->andWhere('category.id = :categoryId')
                ->setParameter('language', $language)
                ->setParameter('categoryId', $categoryId)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

}
