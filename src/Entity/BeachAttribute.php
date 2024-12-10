<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'beach_attributes')]
class BeachAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['beach_attribute'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Beach::class)]
    #[ORM\JoinColumn(name: 'beach_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['beach_attribute'])]
    private ?Beach $beach = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['beach_attribute'])]
    private ?string $attribute = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['beach_attribute'])]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }
   
    public function getBeach(): ?Beach
    {
        return $this->beach;
    }

    public function setBeach(Beach $beach): self
    {
        $this->beach = $beach;
        return $this;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }
   
    public function setAttribute(?string $attribute): self
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
   
    public function setValue(?string $value): self
    {
        $this->value = $value;
        return $this;
    }
}
