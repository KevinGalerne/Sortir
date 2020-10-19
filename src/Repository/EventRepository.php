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
    function findByCriteria($startDate, $endDate, $keyword, $userId, $campus)
    {
        $builder = $this->createQueryBuilder('e');

        if ($campus) {
            $builder->andWhere('e.campus = :campus')
                ->setParameter('campus', $campus);
        }
        if ($userId) {
            $builder->andWhere('e.Author = :userId')
                ->setParameter('userId', $userId);
        }

        if ($startDate) {
            $builder->andWhere('e.eventDate > :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $builder->andWhere('e.eventDate < :endDate')
                ->setParameter('endDate', $endDate);

        }
        if ($keyword) {
            $builder->andWhere('e.description LIKE :description')
                ->orWhere('e.name LIKE :description')
                ->setParameter('description', '%' . $keyword . '%');
        }


        $query = $builder->getQuery();

        return $query->getResult();
    }
}