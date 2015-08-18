<?php

namespace Apb\TypikaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bibliography
 *
 * @ORM\Table(name="typika__bibliography")
 * @ORM\Entity
 */
class Bibliography
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
     * @ORM\Column(name="entry", type="text", length=1024)
     */
    private $entry;


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
     * Set entry
     *
     * @param string $entry
     * @return Bibliography
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return string
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
