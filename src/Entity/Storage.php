<?php

namespace App\Entity;

use App\Repository\StorageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StorageRepository::class)]
#[ORM\Table(name: "storage")]
class Storage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "name", type: "string", length: 50)]
    private ?string $name = null;

    #[ORM\Column(name: "availability", type: "boolean")]
    private ?bool $availability = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAvailability() : ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $u): void
    {
        $this->availability = $u;
    }

}
