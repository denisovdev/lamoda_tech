<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findReservationsByUid(string $reservation_uid): array
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.uid = :reservation_uid')
            ->andWhere("r.status = 'created'")
            ->setParameter('reservation_uid', $reservation_uid);

        return $query->getQuery()->getResult();
    }

    public function findReservationsByUidAndItemId(string $reservation_uid, string $itemId): array
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.uid = :reservation_uid')
            ->andWhere('r.item_id = :item_id')
            ->andWhere("r.status = 'created'")
            ->setParameter('reservation_uid', $reservation_uid)
            ->setParameter('item_id', $itemId);

        return $query->getQuery()->getResult();
    }
}
