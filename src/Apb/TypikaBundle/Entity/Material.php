<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apb\TypikaBundle\Entity\Material
 *
 * @ORM\Table(name="typika__material")
 * @ORM\Entity(repositoryClass="MaterialRepository")
 */
class Material
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

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
     * @return Materiau
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
     * Set prix
     *
     * @param integer $prix
     * @return Materiau
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
    * Override toString() method to return the name of the materiau
    * @return string name
    */
    public function __toString()
    {
        return (string)$this->nom;
    }
}