<?php

namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Users;
use AppBundle\Entity\Address;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /*
    public function loadUserData()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
               'SELECT p.id,p.username
                FROM AppBundle:User p
                LEFT JOIN  AppBundle:Country c ON c.id = p.country
                '
        );

        return $all_country = $query->getResult();
    }
    */
    public function loadUserDetailesById($id){
        return  $this->getEntityManager()
            ->createQuery(
                'SELECT u.id,u.username,u.roles,u.email,a.address as user_address , c.name as country FROM AppBundle:User u 
                        LEFT JOIN AppBundle:Address a WITH a.id = u.address 
                        LEFT JOIN AppBundle:Country c WITH c.id = u.country
                        WHERE u.id = '.$id.'  '
            )
            ->getResult();
    }

}