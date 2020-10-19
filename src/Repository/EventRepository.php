<?php

namespace App\Repository;

use App\Entity\Event;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */

    public function findByKeyword(string $keyword)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.description LIKE :description')
            ->orWhere('e.name LIKE :description')
            ->setParameter('description', '%'.$keyword.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBydate(DateTime $startDate, DateTime $endDate)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.eventDate BETWEEN :startdate AND :enddate')
            ->setParameter('startdate',$startDate)
            ->setParameter('enddate', $endDate)
            ->getQuery()
            ->getResult()
            ;
    }

    
}
