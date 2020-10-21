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

    /**
     * Allow the user to search a list of events based on criteria he selected
     * @return Event[] Returns an array of Event objects
     * @author Kevin & Raphael
     */
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
            $builder
                ->andWhere('e.currentPlace = :currentPlace')
                ->setParameter('currentPlace', "past_activity");
        }

        // 1 - This request return the event where the user is not registered
        if ($nonParticipant) {
            $builder->where(
            // Next line means, on the event.id, return the results where the user is not according to the following request
                $builder->expr()->notIn(
                    'e.id',
                    $this
                        // 2-We re-alias Event table with 'sq' to make a second request
                        ->createQueryBuilder('sq')
                        // 3-Select every Event.id
                        ->select('sq.id')
                        // 4-Join it with the User_event table aliased 'rp2'
                        ->join('sq.registeredParticipants', 'rp2')
                        // 5-Where rp2 has the user id
                        ->where('rp2 = :nonparticipant')
                        ->getDQL()
                )
            // 1-Setting 'non-participant' with the user id
            )->setParameter('nonparticipant', $nonParticipant);
        }

        $query = $builder->getQuery();
        return $query->getResult();
    }


    /**
     * Allow the user to cancel an event he created, this one is deleter from the database
     * @param $eventId
     * @author : Raphael
     */
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