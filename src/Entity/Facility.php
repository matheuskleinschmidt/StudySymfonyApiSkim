<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'facilities')]
class Facility
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['facility'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['facility'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }
   
    public function getName(): ?string
    {
        return $this->name;
    }
   
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
