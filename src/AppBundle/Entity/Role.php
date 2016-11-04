<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 */
class Role
{

    public function __toString() {
        //if variable return in formbuilder in EntityType::class for example
        return $this->role;
    }

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
     * @ORM\Column(name="role", type="string", length=50, columnDefinition="enum('ROLE_USER', 'ROLE_ADMIN', 'ROLE_MANAGER')")
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="role")
     *
     */
    private $group;




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
     * Set role
     *
     * @param string $role
     *
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->group = new ArrayCollection();
    }

    /**
     * Add group
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return Role
     */
    public function addGroup(\AppBundle\Entity\Group $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \AppBundle\Entity\Group $group
     */
    public function removeGroup(\AppBundle\Entity\Group $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroup()
    {
        return $this->group;
    }
}
