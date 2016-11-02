<?php
namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Country;


class CountryRepository extends EntityRepository
{

    public function findAllCountry()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.id,p.code,p.name FROM AppBundle:Country p')
            ->getResult();
    }
    /*
    public function AllCountry()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p.id,p.code,p.name')
            ->from('AppBundle:Country', 'p');


        return $qb;
    }
    */


}