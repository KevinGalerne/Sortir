<?php

namespace App\Repository;

use App\Entity\Event;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;
use function Doctrine\ORM\QueryBuilder;

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


    public function findByCriteria($startDate, $endDate, $keyword, $userId, $campus, $participant, $now, $nonParticipant)
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
        if ($participant) {
            $builder->join('e.registeredParticipants', 'rp')
                ->andWhere('rp = :participant')
                ->setParameter('participant', $participant);
        }
        if ($now) {
            $builder->andWhere('e.eventDate < :now')
                ->setParameter('now', $now);
        }
        if ($nonParticipant) {
            $builder->where(
                $builder->expr()->notIn(
                    'e.id',
                    $this
                        ->createQueryBuilder('sq')
                        ->select('sq.id')
                        ->join('sq.registeredParticipants', 'rp2')
                        ->where('rp2 = :nonparticipant')
                        ->getDQL()
                )
            )->setParameter('nonparticipant', $nonParticipant);
        }
        $query = $builder->getQuery();
        return $query->getResult();
    }

    public function cancelEvent($eventId)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->delete()
            ->where('e.id = :id')
            ->setParameter('id', $eventId);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
}