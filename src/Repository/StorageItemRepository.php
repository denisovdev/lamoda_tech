<?php

namespace App\Repository;

use App\Entity\StorageItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StorageItem>
 */
class StorageItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageItem::class);
    }

    public function getItemAmount(string $itemId): int
    {
        try {
            return $this->createQueryBuilder('si')
                ->select('SUM(si.amount)')
                ->leftJoin('App\Entity\Storage', 's', 'WITH', 's.id = si.storage_id')
                ->where('s.availability = true')
                ->andWhere('si.item_id = :itemId')
                ->setParameter('itemId', $itemId)
                ->groupBy('si.item_id')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e) {
            return 0;
        }
    }

    public function findStoragesWithItem(string $itemId): array
    {
        return $this->createQueryBuilder('si')
            ->select('si')
            ->leftJoin('App\Entity\Storage', 's', 'WITH', 's.id = si.storage_id')
            ->where('s.availability = true')
            ->Andwhere('si.item_id = :itemId')
            ->setParameter('itemId', $itemId)
            ->orderBy('si.amount', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByStorageIdAndItemId(int $storage_id, string $item_id): ?StorageItem
    {
        return $this->createQueryBuilder('si')
            ->where('si.storage_id = :storage_id')
            ->andWhere('si.item_id = :itemId')
            ->setParameter('storage_id', $storage_id)
            ->setParameter('itemId', $item_id)
            ->getQuery()
            ->getSingleResult();
    }
}
