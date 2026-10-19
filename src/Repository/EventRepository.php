<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return list<Event>
     */
    public function findUpcoming(\DateTimeImmutable $now, ?int $limit = null): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.startsAt >= :now')
            ->setParameter('now', $now)
            ->orderBy('e.startsAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<Event>
     */
    public function findPast(\DateTimeImmutable $now, ?int $limit = null): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.startsAt < :now')
            ->setParameter('now', $now)
            ->orderBy('e.startsAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
