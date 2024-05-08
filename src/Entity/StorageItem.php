<?php

namespace App\Entity;

use App\Repository\StorageItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StorageItemRepository::class)]
#[ORM\Table(name: "storage_item")]
class StorageItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $storage_id = null;

    #[ORM\Column(length: 50)]
    private ?string $item_id = null;

    #[ORM\Column]
    private ?int $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStorageId(): ?string
    {
        return $this->storage_id;
    }

    public function setStorageId(string $storage_id): void
    {
        $this->storage_id = $storage_id;
    }

    public function getItemId(): ?string
    {
        return $this->item_id;
    }

    public function setItemId(string $item_id): void
    {
        $this->item_id = $item_id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function increaseAmount(int $amount): void
    {
        $this->amount += $amount;
    }

    public function reduceAmount(int $amount): void
    {
        $this->amount -= $amount;
    }

}
