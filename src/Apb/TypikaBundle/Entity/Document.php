<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="typika__document")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Document
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
     * @ORM\Column(name="biblio", type="string", length=255)
     */
    private $biblio;

    /**
     * @var Authority
     *
     * @ORM\ManyToOne(targetEntity="Authority")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_authority", referencedColumnName="id")
     * })
     */
    private $authority;

    /**
     * @var DocumentType
     *
     * @ORM\ManyToOne(targetEntity="DocumentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string")
     */
    private $date;

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
        return (string)$this->nom;
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
     * @return Document
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Document
     */
    public function setNom2($nom)
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
     * Get nom
     *
     * @return string
     */
    public function getNom2()
    {
        return $this->nom;
    }

    /**
     * Set biblio
     *
     * @param string $biblio
     * @return Document
     */
    public function setBiblio($biblio)
    {
        $this->biblio = $biblio;

        return $this;
    }

    /**
     * Get biblio
     *
     * @return string
     */
    public function getBiblio()
    {
        return $this->biblio;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set authority
     *
     * @param \Apb\TypikaBundle\Entity\Authority $authority
     * @return Document
     */
    public function setAuthority(\Apb\TypikaBundle\Entity\Authority $authority = null)
    {
        $this->authority = $authority;

        return $this;
    }

    /**
     * Get authority
     *
     * @return \Apb\TypikaBundle\Entity\Authority
     */
    public function getAuthority()
    {
        return $this->authority;
    }

    /**
     * Set type
     *
     * @param \Apb\TypikaBundle\Entity\DocumentType $type
     * @return Document
     */
    public function setType(\Apb\TypikaBundle\Entity\DocumentType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Apb\TypikaBundle\Entity\DocumentType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Document
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
