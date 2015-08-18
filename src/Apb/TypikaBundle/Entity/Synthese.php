<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Synthese
 *
 * @ORM\Table(name="typika__synthese")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Synthese
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
     * @ORM\Column(name="greek", type="string", length=255)
     */
    private $greek;

    /**
     * @var string
     *
     * @ORM\Column(name="french", type="string", length=255)
     */
    private $french;

    /**
     * @var string
     *
     * @ORM\Column(name="english", type="string", length=255)
     */
    private $english;

    /**
     * @var string
     *
     * @ORM\Column(name="definition", type="text")
     */
    private $definition;

    /**
     * @var ReferenceSynthese
     *
     * @ORM\OneToMany(targetEntity="ReferenceSynthese", mappedBy="synthese", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"reference" = "ASC"})
     */
    protected $references;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
    *
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }

    public function __toString()
    {
        return (string)$this->greek;
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
     * Set greek
     *
     * @param string $greek
     * @return Synthese
     */
    public function setGreek($greek)
    {
        $this->greek = $greek;

        return $this;
    }

    /**
     * Get greek
     *
     * @return string
     */
    public function getGreek()
    {
        return $this->greek;
    }

    /**
     * Set french
     *
     * @param string $french
     * @return Synthese
     */
    public function setFrench($french)
    {
        $this->french = $french;

        return $this;
    }

    /**
     * Get french
     *
     * @return string
     */
    public function getFrench()
    {
        return $this->french;
    }

    /**
     * Set english
     *
     * @param string $english
     * @return Synthese
     */
    public function setEnglish($english)
    {
        $this->english = $english;

        return $this;
    }

    /**
     * Get english
     *
     * @return string
     */
    public function getEnglish()
    {
        return $this->english;
    }

    /**
     * Set definition
     *
     * @param string $definition
     * @return Synthese
     */
    public function setDefinition($definition)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * Get definition
     *
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->references = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add references
     *
     * @param \Apb\TypikaBundle\Entity\ReferenceSynthese $references
     * @return Synthese
     */
    public function addReference(\Apb\TypikaBundle\Entity\ReferenceSynthese $references)
    {
        $references->setSynthese($this); # pour la collection dans le formulaire
        $this->references[] = $references;
    
        return $this;
    }

    /**
     * Remove references
     *
     * @param \Apb\TypikaBundle\Entity\ReferenceSynthese $references
     */
    public function removeReference(\Apb\TypikaBundle\Entity\ReferenceSynthese $references)
    {
        $this->references->removeElement($references);
    }

    /**
     * Get references
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Synthese
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
