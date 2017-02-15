<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Word;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=50, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * The salt to use for hashing.
     *
     * @ORM\Column(name="salt", type="string")
     */
    protected $salt;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="Word")
     */
    private $wishlist;


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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->words = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add word
     *
     * @param \AppBundle\Entity\Word $word
     *
     * @return User
     */
    public function addWord(\AppBundle\Entity\Word $word)
    {
        $this->words[] = $word;

        return $this;
    }

    /**
     * Remove word
     *
     * @param \AppBundle\Entity\Word $word
     */
    public function removeWord(\AppBundle\Entity\Word $word)
    {
        $this->words->removeElement($word);
    }

    /**
     * Get words
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWords()
    {
        return $this->words;
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function addRole($role){
        $this->roles[] = $role;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Add wishlist
     *
     * @param \AppBundle\Entity\Word $wishlist
     *
     * @return User
     */
    public function addWishlist(\AppBundle\Entity\Word $wishlist)
    {
        $this->wishlist[] = $wishlist;

        return $this;
    }

    /**
     * Remove wishlist
     *
     * @param \AppBundle\Entity\Word $wishlist
     */
    public function removeWishlist(\AppBundle\Entity\Word $wishlist)
    {
        $this->wishlist->removeElement($wishlist);
    }

    /**
     * Get wishlist
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }
}
