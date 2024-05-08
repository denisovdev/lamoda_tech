<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "uid", type: "string")]
    private ?string $uid = null;

    #[ORM\Column(name: "storage_id", type: "integer")]
    private ?int $storage_id = null;

    #[ORM\Column(name: "item_id", type: "string")]
    private ?string $item_id = null;

    #[ORM\Column(name: "amount", type: "integer")]
    private ?int $amount = null;

    #[ORM\Column(name: "status", type: "string")]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(?string $uid): void
    {
        $this->uid = $uid;
    }

    public function getStorageId(): ?int
    {
        return $this->storage_id;
    }

    public function setStorageId(?int $storage_id): void
    {
        $this->storage_id = $storage_id;
    }

    public function getItemId(): ?string
    {
        return $this->item_id;
    }

    public function setItemId(?string $item_id): void
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatusCreated(): void
    {
        $this->status = 'created';
    }
    public function setStatusCancelled(): void
    {
        $this->status = 'cancelled';
    }
}
