<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reference
 *
 * @ORM\Table(name="typika__reference")
 * @ORM\Entity
 */
class Reference
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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=512, nullable = true)
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
     * @var Artefact
     *
     * @ORM\ManyToOne(targetEntity="Artefact")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_artefact", referencedColumnName="id")
     * })
     */
    private $artefact;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_reference", type="integer")
     */
    private $position;

    public function __toString()
    {
        return (string)$this->text;
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
     * Set position
     *
     * @param integer $position
     * @return Reference
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set artefact
     *
     * @param \Apb\TypikaBundle\Entity\Artefact $artefact
     * @return Reference
     */
    public function setArtefact(\Apb\TypikaBundle\Entity\Artefact $artefact = null)
    {
        $this->artefact = $artefact;
    
        return $this;
    }

    /**
     * Get artefact
     *
     * @return \Apb\TypikaBundle\Entity\Artefact 
     */
    public function getArtefact()
    {
        return $this->artefact;
    }

    /**
     * Set object
     *
     * @param string $object
     * @return Reference
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
     * @return Reference
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
