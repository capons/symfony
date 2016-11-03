<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Table(name="user_permission")
* @ORM\Entity()
*/
class Group implements RoleInterface
{
/**
* @ORM\Column(name="id", type="integer")
* @ORM\Id()
* @ORM\GeneratedValue(strategy="AUTO")
*/
private $id;

/** @ORM\Column(name="name", type="string", length=30) */
private $name;

/** @ORM\Column(name="role", type="string", length=20) */
private $role;

    //relationship with User entity
/** @ORM\ManyToMany(targetEntity="User", mappedBy="groups") */
private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->setRole('ROLE_USER');
    }

// ... getters and setters for each property

    /** @see RoleInterface */
    public function getRole()
    {
    return $this->role;
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
     * Set name
     *
     * @param string $name
     *
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Group
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Group
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
}
