<?php

namespace Apb\MonumentsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ChapitreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChapitreRepository extends EntityRepository
{
    /**
     * {@inheritDoc}
     * 
     * @return array The entities.
     */
    public function findBy(array $criteria, array $orderBy = array('name' => 'asc'), $limit = null, $offset = null)
    {
        return parent::findBy(array(), $orderBy, $limit, $offset);
    }
}
