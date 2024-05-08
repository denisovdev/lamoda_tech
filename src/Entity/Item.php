<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\Column(name: "id", type: "string")]
    #[ORM\GeneratedValue]
//    #[ORM\GeneratedValue(strategy: "CUSTOM")]
//    #[ORM\CustomIdGenerator(UidGenerator::class)]
    private ?string $id = null;

    #[ORM\Column(name: "name", type: "string")]
    private ?string $name = null;
    
    #[ORM\Column(name: "size", type: "string")]
    private ?string $size = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
    }
}
