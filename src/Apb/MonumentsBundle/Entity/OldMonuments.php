<?php

namespace Apb\MonumentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OldMonuments
 *
 * @ORM\Table(name="old_monuments")
 * @ORM\Entity
 */
class OldMonuments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=255, nullable=true)
     */
    private $section;

    /**
     * @var string
     *
     * @ORM\Column(name="chapitre", type="string", length=255, nullable=true)
     */
    private $chapitre;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @var string
     *
     * @ORM\Column(name="monuments", type="string", length=255, nullable=true)
     */
    private $monuments;

    /**
     * @var string
     *
     * @ORM\Column(name="iconographie", type="string", length=255, nullable=true)
     */
    private $iconographie;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="notices", type="text", nullable=true)
     */
    private $notices;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="field11", type="string", length=255, nullable=true)
     */
    private $field11;

    /**
     * @var string
     *
     * @ORM\Column(name="siecle", type="string", length=255, nullable=true)
     */
    private $siecle;







    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_section;

    /**
     * @var Chapitre
     *
     * @ORM\ManyToOne(targetEntity="Chapitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chapitre_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_chapitre;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_categorie;

    /**
     * @var Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pays_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_pays;

    /**
     * @var Lieu
     *
     * @ORM\ManyToOne(targetEntity="Lieu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lieu_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_lieu;

    /**
     * @var Monuments
     *
     * @ORM\ManyToOne(targetEntity="Monuments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="monuments_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_monuments;

    /**
     * @var Iconographie
     *
     * @ORM\ManyToOne(targetEntity="Iconographie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iconographie_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_iconographie;





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
     * Set section
     *
     * @param string $section
     * @return OldMonuments
     */
    public function setSection($section)
    {
        $this->section = $section;
    
        return $this;
    }

    /**
     * Get section
     *
     * @return string 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set chapitre
     *
     * @param string $chapitre
     * @return OldMonuments
     */
    public function setChapitre($chapitre)
    {
        $this->chapitre = $chapitre;
    
        return $this;
    }

    /**
     * Get chapitre
     *
     * @return string 
     */
    public function getChapitre()
    {
        return $this->chapitre;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return OldMonuments
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return OldMonuments
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    
        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     * @return OldMonuments
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    
        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set monuments
     *
     * @param string $monuments
     * @return OldMonuments
     */
    public function setMonuments($monuments)
    {
        $this->monuments = $monuments;
    
        return $this;
    }

    /**
     * Get monuments
     *
     * @return string 
     */
    public function getMonuments()
    {
        return $this->monuments;
    }

    /**
     * Set iconographie
     *
     * @param string $iconographie
     * @return OldMonuments
     */
    public function setIconographie($iconographie)
    {
        $this->iconographie = $iconographie;
    
        return $this;
    }

    /**
     * Get iconographie
     *
     * @return string 
     */
    public function getIconographie()
    {
        return $this->iconographie;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return OldMonuments
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
     * @return OldMonuments
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
     * @return OldMonuments
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
     * Set field11
     *
     * @param string $field11
     * @return OldMonuments
     */
    public function setField11($field11)
    {
        $this->field11 = $field11;
    
        return $this;
    }

    /**
     * Get field11
     *
     * @return string 
     */
    public function getField11()
    {
        return $this->field11;
    }

    /**
     * Set siecle
     *
     * @param string $siecle
     * @return OldMonuments
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
     * Set id_section
     *
     * @param \Apb\MonumentsBundle\Entity\Section $idSection
     * @return OldMonuments
     */
    public function setIdSection(\Apb\MonumentsBundle\Entity\Section $idSection = null)
    {
        $this->id_section = $idSection;
    
        return $this;
    }

    /**
     * Get id_section
     *
     * @return \Apb\MonumentsBundle\Entity\Section 
     */
    public function getIdSection()
    {
        return $this->id_section;
    }

    /**
     * Set id_chapitre
     *
     * @param \Apb\MonumentsBundle\Entity\Chapitre $idChapitre
     * @return OldMonuments
     */
    public function setIdChapitre(\Apb\MonumentsBundle\Entity\Chapitre $idChapitre = null)
    {
        $this->id_chapitre = $idChapitre;
    
        return $this;
    }

    /**
     * Get id_chapitre
     *
     * @return \Apb\MonumentsBundle\Entity\Chapitre 
     */
    public function getIdChapitre()
    {
        return $this->id_chapitre;
    }

    /**
     * Set id_categorie
     *
     * @param \Apb\MonumentsBundle\Entity\Categorie $idCategorie
     * @return OldMonuments
     */
    public function setIdCategorie(\Apb\MonumentsBundle\Entity\Categorie $idCategorie = null)
    {
        $this->id_categorie = $idCategorie;
    
        return $this;
    }

    /**
     * Get id_categorie
     *
     * @return \Apb\MonumentsBundle\Entity\Categorie 
     */
    public function getIdCategorie()
    {
        return $this->id_categorie;
    }

    /**
     * Set id_pays
     *
     * @param \Apb\MonumentsBundle\Entity\Pays $idPays
     * @return OldMonuments
     */
    public function setIdPays(\Apb\MonumentsBundle\Entity\Pays $idPays = null)
    {
        $this->id_pays = $idPays;
    
        return $this;
    }

    /**
     * Get id_pays
     *
     * @return \Apb\MonumentsBundle\Entity\Pays 
     */
    public function getIdPays()
    {
        return $this->id_pays;
    }

    /**
     * Set id_lieu
     *
     * @param \Apb\MonumentsBundle\Entity\Lieu $idLieu
     * @return OldMonuments
     */
    public function setIdLieu(\Apb\MonumentsBundle\Entity\Lieu $idLieu = null)
    {
        $this->id_lieu = $idLieu;
    
        return $this;
    }

    /**
     * Get id_lieu
     *
     * @return \Apb\MonumentsBundle\Entity\Lieu 
     */
    public function getIdLieu()
    {
        return $this->id_lieu;
    }

    /**
     * Set id_monuments
     *
     * @param \Apb\MonumentsBundle\Entity\Monuments $idMonuments
     * @return OldMonuments
     */
    public function setIdMonuments(\Apb\MonumentsBundle\Entity\Monuments $idMonuments = null)
    {
        $this->id_monuments = $idMonuments;
    
        return $this;
    }

    /**
     * Get id_monuments
     *
     * @return \Apb\MonumentsBundle\Entity\Monuments 
     */
    public function getIdMonuments()
    {
        return $this->id_monuments;
    }

    /**
     * Set id_iconographie
     *
     * @param \Apb\MonumentsBundle\Entity\Iconographie $idIconographie
     * @return OldMonuments
     */
    public function setIdIconographie(\Apb\MonumentsBundle\Entity\Iconographie $idIconographie = null)
    {
        $this->id_iconographie = $idIconographie;
    
        return $this;
    }

    /**
     * Get id_iconographie
     *
     * @return \Apb\MonumentsBundle\Entity\Iconographie 
     */
    public function getIdIconographie()
    {
        return $this->id_iconographie;
    }
}