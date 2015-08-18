<?php

namespace Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseUser
 *
 * @ORM\Table(name="BaseUser")
 * @ORM\MappedSuperClass
 * @ORM\HasLifecycleCallbacks
 */
class BaseUser
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=64, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=64, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=64, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="string", length=255, nullable=true)
     */
    private $biography;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=8, nullable=true)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=64, nullable=true)
     */
    private $timezone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=64, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_uid", type="string", length=255, nullable=true)
     */
    private $facebookUid;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_name", type="string", length=255, nullable=true)
     */
    private $facebookName;

    /**
     * @var json
     *
     * @ORM\Column(name="facebook_data", type="json", nullable=true)
     */
    private $facebookData;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_uid", type="string", length=255, nullable=true)
     */
    private $twitterUid;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_name", type="string", length=255, nullable=true)
     */
    private $twitterName;

    /**
     * @var json
     *
     * @ORM\Column(name="twitter_data", type="json", nullable=true)
     */
    private $twitterData;

    /**
     * @var string
     *
     * @ORM\Column(name="gplus_uid", type="string", length=255, nullable=true)
     */
    private $gplusUid;

    /**
     * @var string
     *
     * @ORM\Column(name="gplus_name", type="string", length=255, nullable=true)
     */
    private $gplusName;

    /**
     * @var json
     *
     * @ORM\Column(name="gplus_data", type="json", nullable=true)
     */
    private $gplusData;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="two_step_code", type="string", length=255, nullable=true)
     */
    private $twoStepVerificationCode;


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        // Add your code here
    }
}
