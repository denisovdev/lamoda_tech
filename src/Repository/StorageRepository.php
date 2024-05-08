<?php

namespace App\Repository;

use App\Entity\Storage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Storage>
 */
class StorageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Storage::class);
    }

    public function findItems(int $storageId, int $currentPage, int $limit): array
    {
        return $this->createQueryBuilder('s')
            ->select('si.item_id', 'i.name', 'si.amount')
            ->leftJoin('App\Entity\StorageItem', 'si', 'WITH', 'si.storage_id = s.id')
            ->leftJoin('App\Entity\Item', 'i', 'WITH', 'si.item_id = i.id')
            ->where('s.id = :storageId')
            ->setParameter('storageId', $storageId)
            ->orderBy('si.item_id', 'ASC')
            ->setFirstResult(($currentPage - 1) * $limit)
            ->setMaxResults($currentPage * $limit)
            ->getQuery()
            ->getArrayResult();
    }
}
