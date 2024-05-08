<?php

namespace App\Entity;

use Doctrine\ORM\EntityManagerInterface;

class UidGenerator
{
    public function generateUid(EntityManagerInterface $em, string $entity, string $column='id'): string {
        $uuid = bin2hex(random_bytes(8));

        if (null !== $em->getRepository($entity)->findOneBy([$column => $uuid])) {
            $uuid = $this->generateUid($em, $entity, $column);
        }

        return $uuid;
    }
}
