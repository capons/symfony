<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Country;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * User
 *
 * @ORM\Table(name="user",options={"collate"="utf8_general_ci"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{

    public function __construct()
    {
        //set default Entity variable
        $this->isActive = true;
        $this->roles = 'ROLE_USER'; //default role

    }


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotNull(message="You have to choose a username (this is my custom validation message).")
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotNull(message="Password error (this is my custom validation message).")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotNull(message="Please enter email address")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.", checkMX = true )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters"
     * )
     */
    private $email;



    /**
     *
     * @ORM\Column(type="string", length=60)
     *
     *
     */
    private $address;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    //related with entity Country
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="user")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $country;


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this->password;
    }

    public function getRoles()
    {
        return array($this->roles);
    }
    public function setRoles($role)
    {
        $this->roles = $role;
        return $this->roles;
    }
    //email field get set method
    public function getEmail()
    {
        return $this->email;
    }
    public function SetEmail($email)
    {
        $this->email = $email;
        return $this->email;
    }



    public function eraseCredentials()
    {
    }


    /** @see \Serializable::serialize() */

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }


    /** @see \Serializable::unserialize() */

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


   
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }




    /**
     * Set country
     *
     * @param \AppBundle\Entity\Country $country
     *
     * @return User
     */
    public function setCountry(\AppBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AppBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
