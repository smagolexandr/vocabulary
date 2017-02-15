<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 */
class Word
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="en", type="string", length=50)
     */
    private $en;

    /**
     * @var string
     *
     * @ORM\Column(name="uk", type="string", length=50)
     */
    private $uk;

    /**
     * @var string
     *
     * @ORM\Column(name="ru", type="string", length=50)
     */
    private $ru;

    /**
     * @var string
     *
     * @ORM\Column(name="de", type="string", length=50)
     */
    private $de;

    /**
     * @var string
     *
     * @ORM\Column(name="pl", type="string", length=50)
     */
    private $pl;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $users;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return Word
     */
    public function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }
    
    /**
     * Set ru
     *
     * @param string $ru
     *
     * @return Word
     */
    public function setRu($ru)
    {
        $this->ru = $ru;

        return $this;
    }

    /**
     * Get ru
     *
     * @return string
     */
    public function getRu()
    {
        return $this->ru;
    }

    /**
     * Set de
     *
     * @param string $de
     *
     * @return Word
     */
    public function setDe($de)
    {
        $this->de = $de;

        return $this;
    }

    /**
     * Get de
     *
     * @return string
     */
    public function getDe()
    {
        return $this->de;
    }

    /**
     * Set pl
     *
     * @param string $pl
     *
     * @return Word
     */
    public function setPl($pl)
    {
        $this->pl = $pl;

        return $this;
    }

    /**
     * Get pl
     *
     * @return string
     */
    public function getPl()
    {
        return $this->pl;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Word
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set uk
     *
     * @param string $uk
     *
     * @return Word
     */
    public function setUk($uk)
    {
        $this->uk = $uk;

        return $this;
    }

    /**
     * Get uk
     *
     * @return string
     */
    public function getUk()
    {
        return $this->uk;
    }

    /**
     * Set users
     *
     * @param \AppBundle\Entity\User $users
     *
     * @return Word
     */
    public function setUsers(\AppBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }
}
