<?php

namespace Apb\DiathequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nbcouleur
 *
 * @ORM\Table(name="diatheque__nbcouleur")
 * @ORM\Entity
 */
class Nbcouleur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nbcouleur", type="string", length=255)
     */
    private $nbcouleur;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    public function __toString()
    {
        return $this->getNbcouleur();
    }

    /**
     * Set nbcouleur
     *
     * @param string $nbcouleur
     * @return nbcouleur
     */
    public function setNbcouleur($nbcouleur)
    {
        $this->nbcouleur = $nbcouleur;

        return $this;
    }

    /**
     * Get nbcouleur
     *
     * @return string
     */
    public function getNbcouleur()
    {
        return $this->nbcouleur;
    }
}