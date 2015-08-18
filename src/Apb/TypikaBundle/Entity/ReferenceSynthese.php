<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reference
 *
 * @ORM\Table(name="typika__referencesynthese")
 * @ORM\Entity
 */
class ReferenceSynthese
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
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=512, nullable=false, nullable = true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=512)
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="id_object", type="integer")
     */
    private $id_object;

    /**
     * @var Synthese
     *
     * @ORM\ManyToOne(targetEntity="Synthese")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_synthese", referencedColumnName="id")
     * })
     */
    private $synthese;

#    /**
#     * @var Reference
#     *
#     * @ORM\ManyToOne(targetEntity="Reference")
#     * @ORM\JoinColumns({
#     *   @ORM\JoinColumn(name="id_reference", referencedColumnName="id")
#     * })
#     */
#    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_reference", type="integer", nullable=false)
     */
    private $reference;

    public function __toString()
    {
        return (string)$this->id . " " . $this->text;
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
     * Set text
     *
     * @param string $text
     * @return Reference
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Reference
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set synthese
     *
     * @param \Apb\TypikaBundle\Entity\Synthese $synthese
     * @return ReferenceSynthese
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
     * Set reference
     *
     * @param integer $reference
     * @return ReferenceSynthese
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return integer 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set object
     *
     * @param string $object
     * @return ReferenceSynthese
     */
    public function setObject($object)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return string 
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set id_object
     *
     * @param integer $idObject
     * @return ReferenceSynthese
     */
    public function setIdObject($idObject)
    {
        $this->id_object = $idObject;
    
        return $this;
    }

    /**
     * Get id_object
     *
     * @return integer 
     */
    public function getIdObject()
    {
        return $this->id_object;
    }
}
