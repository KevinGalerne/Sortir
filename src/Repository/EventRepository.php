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


    public
    function findBydate(DateTime $startDate, DateTime $endDate, string $keyword, string $userId)
    {
        $builder = $this->createQueryBuilder('e');
        if ($startDate) {
            $builder->andWhere('e.eventDate >= : startDate')
                ->setParameter('startdate', $startDate);
        }
        if ($endDate) {
            $builder->andWhere('e.eventDate <= : endDate')
                ->setParameter('enddate', $endDate);
        }
        if ($keyword) {
            $builder->andWhere('e.description LIKE :description')
                ->orWhere('e.name LIKE :description')
                ->setParameter('description', '%' . $keyword . '%');
        }
        if ($userId) {
            $builder->andWhere('e.Author = :userId')
                ->setParameter('userId', $userId);
        }

        $builder->getQuery()
            ->getResult();


    }
}