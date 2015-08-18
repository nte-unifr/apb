<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apb\TypikaBundle\Entity\Artefact
 *
 * @ORM\Table(name="typika__artefact")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Artefact
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_document", referencedColumnName="id")
     * })
     */
    private $document;

    /**
     * @var string $reference
     *
     * @ORM\Column(name="reference", type="string", length=100, nullable=false)
     */
    private $reference;

    /**
     * @var string $greek
     *
     * @ORM\Column(name="greek", type="string", length=512, nullable=false)
     */
    private $greek;

    /**
     * @var string $greek_trans
     *
     * @ORM\Column(name="greek_trans", type="string", length=255, nullable=false)
     */
    private $greek_trans;

    /**
     * @var string $french
     *
     * @ORM\Column(name="french", type="string", length=255, nullable=false)
     */
    private $french;

    /**
     * @var string $english
     *
     * @ORM\Column(name="english", type="string", length=255, nullable=false)
     */
    private $english;

    /**
     * @var string $context
     *
     * @ORM\Column(name="context", type="text", nullable=true)
     */
    private $context;

    /**
     * @var string $comments
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_category", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var Fonction
     *
     * @ORM\ManyToOne(targetEntity="Fonction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fonction", referencedColumnName="id")
     * })
     */
    private $fonction;

    /**
     * @var Material
     *
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_material", referencedColumnName="id", nullable=true)
     * })
     */
    private $material;

    /**
     * @var Material_2
     *
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_material_2", referencedColumnName="id", nullable=true)
     * })
     */
    private $material_2;

    /**
     * @var Material_3
     *
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_material_3", referencedColumnName="id", nullable=true)
     * })
     */
    private $material_3;

    /**
     * @var Synthese
     *
     * @ORM\ManyToOne(targetEntity="Synthese")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_synthese", referencedColumnName="id")
     * })
     */
    private $synthese;

    /**
     * @var Reference
     *
     * @ORM\OneToMany(targetEntity="Reference", mappedBy="artefact", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
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
        return (string)($this->getId().' '.$this->getGreek());
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
     * Set reference
     *
     * @param string $reference
     * @return Artefact
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
     * Set greek
     *
     * @param string $greek
     * @return Artefact
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
     * Set greek_trans
     *
     * @param string $greekTrans
     * @return Artefact
     */
    public function setGreekTrans($greekTrans)
    {
        $this->greek_trans = $greekTrans;
    
        return $this;
    }

    /**
     * Get greek_trans
     *
     * @return string 
     */
    public function getGreekTrans()
    {
        return $this->greek_trans;
    }

    /**
     * Set french
     *
     * @param string $french
     * @return Artefact
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
     * @return Artefact
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
     * Set context
     *
     * @param string $context
     * @return Artefact
     */
    public function setContext($context)
    {
        $this->context = $context;
    
        return $this;
    }

    /**
     * Get context
     *
     * @return string 
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Artefact
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    
        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set document
     *
     * @param \Apb\TypikaBundle\Entity\Document $document
     * @return Artefact
     */
    public function setDocument(\Apb\TypikaBundle\Entity\Document $document = null)
    {
        $this->document = $document;
    
        return $this;
    }

    /**
     * Get document
     *
     * @return \Apb\TypikaBundle\Entity\Document 
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set category
     *
     * @param \Apb\TypikaBundle\Entity\Category $category
     * @return Artefact
     */
    public function setCategory(\Apb\TypikaBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Apb\TypikaBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set fonction
     *
     * @param \Apb\TypikaBundle\Entity\Fonction $fonction
     * @return Artefact
     */
    public function setFonction(\Apb\TypikaBundle\Entity\Fonction $fonction = null)
    {
        $this->fonction = $fonction;
    
        return $this;
    }

    /**
     * Get fonction
     *
     * @return \Apb\TypikaBundle\Entity\Fonction 
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set material
     *
     * @param \Apb\TypikaBundle\Entity\Material $material
     * @return Artefact
     */
    public function setMaterial(\Apb\TypikaBundle\Entity\Material $material = null)
    {
        $this->material = $material;
    
        return $this;
    }

    /**
     * Get material
     *
     * @return \Apb\TypikaBundle\Entity\Material 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set material_2
     *
     * @param \Apb\TypikaBundle\Entity\Material $material2
     * @return Artefact
     */
    public function setMaterial2(\Apb\TypikaBundle\Entity\Material $material2 = null)
    {
        $this->material_2 = $material2;
    
        return $this;
    }

    /**
     * Get material_2
     *
     * @return \Apb\TypikaBundle\Entity\Material 
     */
    public function getMaterial2()
    {
        return $this->material_2;
    }

    /**
     * Set material_3
     *
     * @param \Apb\TypikaBundle\Entity\Material $material3
     * @return Artefact
     */
    public function setMaterial3(\Apb\TypikaBundle\Entity\Material $material3 = null)
    {
        $this->material_3 = $material3;
    
        return $this;
    }

    /**
     * Get material_3
     *
     * @return \Apb\TypikaBundle\Entity\Material 
     */
    public function getMaterial3()
    {
        return $this->material_3;
    }

    /**
     * Set synthese
     *
     * @param \Apb\TypikaBundle\Entity\Synthese $synthese
     * @return Artefact
     */
    public function setSynthese(\Apb\TypikaBundle\Entity\Synthese $synthese = null)
    {
        $this->synthese = $synthese;
    
        return $this;
    }

    /**
     * Get synthese
     *
     * @return \Apb\TypikaBundle\Entity\Synthese 
     */
    public function getSynthese()
    {
        return $this->synthese;
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
     * @param \Apb\TypikaBundle\Entity\Reference $references
     * @return Artefact
     */
    public function addReference(\Apb\TypikaBundle\Entity\Reference $references)
    {
        $references->setArtefact($this); # pour la collection dans le formulaire
        $this->references[] = $references;
    
        return $this;
    }

    /**
     * Remove references
     *
     * @param \Apb\TypikaBundle\Entity\Reference $references
     */
    public function removeReference(\Apb\TypikaBundle\Entity\Reference $references)
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
     * Set nom
     *
     * @param string $nom
     * @return Artefact
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Artefact
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
