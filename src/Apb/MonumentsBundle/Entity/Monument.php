<?php

namespace Apb\MonumentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Monument
 *
 * @ORM\Table(name="monuments__monument")
 * @ORM\Entity
 */
class Monument
{

    /**
     * @var Media $images
     *
     * @ORM\OneToMany(targetEntity="MonumentImages", mappedBy="fiche", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $section;

    /**
     * @var Chapitre
     *
     * @ORM\ManyToOne(targetEntity="Chapitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chapitre_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $chapitre;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $categorie;

    /**
     * @var Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pays_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $pays;

    /**
     * @var Lieu
     *
     * @ORM\ManyToOne(targetEntity="Lieu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lieu_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $lieu;

    /**
     * @var Monuments
     *
     * @ORM\ManyToOne(targetEntity="Monuments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="monuments_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $monuments;

    /**
     * @var Iconographie
     *
     * @ORM\ManyToOne(targetEntity="Iconographie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iconographie_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $iconographie;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="notices", type="text")
     */
    private $notices;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="siecle", type="string", length=255)
     */
    private $siecle;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

#    /**
#     * @var string
#     *
#     * @ORM\Column(name="statut", type="string", length=255)
#     */
#    private $statut;

    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set date
     *
     * @param string $date
     * @return Monument
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
     * Set notices
     *
     * @param string $notices
     * @return Monument
     */
    public function setNotices($notices)
    {
        $this->notices = $notices;

        return $this;
    }

    /**
     * Get notices
     *
     * @return string
     */
    public function getNotices()
    {
        return $this->notices;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Monument
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set siecle
     *
     * @param string $siecle
     * @return Monument
     */
    public function setSiecle($siecle)
    {
        $this->siecle = $siecle;

        return $this;
    }

    /**
     * Get siecle
     *
     * @return string
     */
    public function getSiecle()
    {
        return $this->siecle;
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
     * Add images
     *
     * @param \Apb\MonumentsBundle\Entity\MonumentImages $images
     * @return Monument
     */
    public function addImage(\Apb\MonumentsBundle\Entity\MonumentImages $images)
    {
        $images->setFiche($this); # pour la collection dans le formulaire
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Apb\MonumentsBundle\Entity\MonumentImages $images
     */
    public function removeImage(\Apb\MonumentsBundle\Entity\MonumentImages $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set section
     *
     * @param \Apb\MonumentsBundle\Entity\Section $section
     * @return Monument
     */
    public function setSection(\Apb\MonumentsBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \Apb\MonumentsBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set chapitre
     *
     * @param \Apb\MonumentsBundle\Entity\Chapitre $chapitre
     * @return Monument
     */
    public function setChapitre(\Apb\MonumentsBundle\Entity\Chapitre $chapitre = null)
    {
        $this->chapitre = $chapitre;

        return $this;
    }

    /**
     * Get chapitre
     *
     * @return \Apb\MonumentsBundle\Entity\Chapitre
     */
    public function getChapitre()
    {
        return $this->chapitre;
    }

    /**
     * Set categorie
     *
     * @param \Apb\MonumentsBundle\Entity\Categorie $categorie
     * @return Monument
     */
    public function setCategorie(\Apb\MonumentsBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Apb\MonumentsBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set pays
     *
     * @param \Apb\MonumentsBundle\Entity\Pays $pays
     * @return Monument
     */
    public function setPays(\Apb\MonumentsBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Apb\MonumentsBundle\Entity\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set lieu
     *
     * @param \Apb\MonumentsBundle\Entity\Lieu $lieu
     * @return Monument
     */
    public function setLieu(\Apb\MonumentsBundle\Entity\Lieu $lieu = null)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return \Apb\MonumentsBundle\Entity\Lieu
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set monuments
     *
     * @param \Apb\MonumentsBundle\Entity\Monuments $monuments
     * @return Monument
     */
    public function setMonuments(\Apb\MonumentsBundle\Entity\Monuments $monuments = null)
    {
        $this->monuments = $monuments;

        return $this;
    }

    /**
     * Get monuments
     *
     * @return \Apb\MonumentsBundle\Entity\Monuments
     */
    public function getMonuments()
    {
        return $this->monuments;
    }

    /**
     * Set iconographie
     *
     * @param \Apb\MonumentsBundle\Entity\Iconographie $iconographie
     * @return Monument
     */
    public function setIconographie(\Apb\MonumentsBundle\Entity\Iconographie $iconographie = null)
    {
        $this->iconographie = $iconographie;

        return $this;
    }

    /**
     * Get iconographie
     *
     * @return \Apb\MonumentsBundle\Entity\Iconographie
     */
    public function getIconographie()
    {
        return $this->iconographie;
    }

    /**
     * Set statut
     *
     * @param string $statut
     * @return Monument
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
