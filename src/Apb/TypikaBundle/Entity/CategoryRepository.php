<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
     * {@inheritDoc}
     * 
     * @return array The entities.
     */
    public function findBy(array $criteria, array $orderBy = array('nom' => 'asc', 'nom2' => 'asc'), $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
