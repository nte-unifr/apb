<?php

namespace Apb\DiathequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dia
 *
 * @ORM\Table(name="diatheque__dia")
 * @ORM\Entity
 */
class Dia
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
     * @ORM\Column(name="fiche", type="string", length=255)
     */
    private $fiche;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie1", referencedColumnName="id", nullable=true)
     * })
     */
    private $categorie1;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie2", referencedColumnName="id", nullable=true)
     * })
     */
    private $categorie2;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="monument", type="string", length=255, nullable=true)
     */
    private $monument;

    /**
     * @var string
     *
     * @ORM\Column(name="mots_cles", type="string", length=255, nullable=true)
     */
    private $motsCles;

    /**
     * @var Nbcouleur
     *
     * @ORM\ManyToOne(targetEntity="Nbcouleur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nb_couleur", referencedColumnName="id", nullable=true)
     * })
     */
    private $nbCouleur;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var boolean
     *
     * @ORM\Column(name="selection", type="boolean")
     */
    private $selection;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $image;


    public function __toString()
    {
        return $this->fiche;
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
     * Set fiche
     *
     * @param string $fiche
     * @return Dia
     */
    public function setFiche($fiche)
    {
        $this->fiche = $fiche;

        return $this;
    }

    /**
     * Get fiche
     *
     * @return string
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Dia
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set monument
     *
     * @param string $monument
     * @return Dia
     */
    public function setMonument($monument)
    {
        $this->monument = $monument;

        return $this;
    }

    /**
     * Get monument
     *
     * @return string
     */
    public function getMonument()
    {
        return $this->monument;
    }

    /**
     * Set motsCles
     *
     * @param string $motsCles
     * @return Dia
     */
    public function setMotsCles($motsCles)
    {
        $this->motsCles = $motsCles;

        return $this;
    }

    /**
     * Get motsCles
     *
     * @return string
     */
    public function getMotsCles()
    {
        return $this->motsCles;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Dia
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set selection
     *
     * @param boolean $selection
     * @return Dia
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * Get selection
     *
     * @return boolean
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * Set categorie1
     *
     * @param \Apb\DiathequeBundle\Entity\Categorie $categorie1
     * @return Dia
     */
    public function setCategorie1(\Apb\DiathequeBundle\Entity\Categorie $categorie1 = null)
    {
        $this->categorie1 = $categorie1;

        return $this;
    }

    /**
     * Get categorie1
     *
     * @return \Apb\DiathequeBundle\Entity\Categorie
     */
    public function getCategorie1()
    {
        return $this->categorie1;
    }

    /**
     * Set categorie2
     *
     * @param \Apb\DiathequeBundle\Entity\Categorie $categorie2
     * @return Dia
     */
    public function setCategorie2(\Apb\DiathequeBundle\Entity\Categorie $categorie2 = null)
    {
        $this->categorie2 = $categorie2;

        return $this;
    }

    /**
     * Get categorie2
     *
     * @return \Apb\DiathequeBundle\Entity\Categorie
     */
    public function getCategorie2()
    {
        return $this->categorie2;
    }

    /**
     * Set nbCouleur
     *
     * @param \Apb\DiathequeBundle\Entity\Nbcouleur $nbCouleur
     * @return Dia
     */
    public function setNbCouleur(\Apb\DiathequeBundle\Entity\Nbcouleur $nbCouleur = null)
    {
        $this->nbCouleur = $nbCouleur;

        return $this;
    }

    /**
     * Get nbCouleur
     *
     * @return \Apb\DiathequeBundle\Entity\Nbcouleur
     */
    public function getNbCouleur()
    {
        return $this->nbCouleur;
    }

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Dia
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }
}
