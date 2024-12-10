<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'cities')]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['city'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['city'])]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: State::class)]
    #[ORM\JoinColumn(name: 'state_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['city'])]
    private ?State $state = null;

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

    public function getState(): ?State
    {
        return $this->state;
    }
   
    public function setState(State $state): self
    {
        $this->state = $state;
        return $this;
    }
}
