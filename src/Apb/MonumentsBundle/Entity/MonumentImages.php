<?php

namespace Apb\MonumentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonumentImages
 *
 * @ORM\Table(name="monuments__images")
 * @ORM\Entity
 */
class MonumentImages
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Monument", cascade={"detach"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="monument_id", referencedColumnName="id")
     * })
     */
    private $fiche;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"detach"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * })
     */
    private $media;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

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
     * @param \Apb\MonumentsBundle\Entity\Monument $fiche
     * @return MonumentImages
     */
    public function setFiche(\Apb\MonumentsBundle\Entity\Monument $fiche = null)
    {
        $this->fiche = $fiche;
    
        return $this;
    }

    /**
     * Get fiche
     *
     * @return \Apb\MonumentsBundle\Entity\Monument 
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return MonumentImages
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;
    
        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return MonumentImages
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return MonumentImages
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
