<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="typika__category")
 * @ORM\Entity(repositoryClass="CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom2", type="string", length=255)
     */
    private $nom2;

    public function __toString()
    {
        return (string)($this->getNom() . " / " . $this->getNom2());
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Category
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom2
     *
     * @param string $nom2
     * @return Category
     */
    public function setNom2($nom2)
    {
        $this->nom2 = $nom2;

        return $this;
    }

    /**
     * Get nom2
     *
     * @return string
     */
    public function getNom2()
    {
        return $this->nom2;
    }
}
