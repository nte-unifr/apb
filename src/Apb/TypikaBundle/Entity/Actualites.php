<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="typika__actualite")
 * @ORM\Entity
 */
class Actualites
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
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="introduction", type="text", nullable=true)
     */
    private $introduction;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;
    /**
     * @var boolean
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true)
     */
    private $archive;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;


    public function __toString()
    {
        return (string)$this->title;
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
     * Set title
     *
     * @param string $title
     * @return Actualites
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set introduction
     *
     * @param string $introduction
     * @return Actualites
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;
    
        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Actualites
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
     * Set archive
     *
     * @param boolean $archive
     * @return Actualites
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    
        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean 
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Actualites
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
}