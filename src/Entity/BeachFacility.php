<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'beach_facilities')]
class BeachFacility
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['beach_facility'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Beach::class)]
    #[ORM\JoinColumn(name: 'beach_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['beach_facility'])]
    private ?Beach $beach = null;

    #[ORM\ManyToOne(targetEntity: Facility::class)]
    #[ORM\JoinColumn(name: 'facility_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['beach_facility'])]
    private ?Facility $facility = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['beach_facility'])]
    private ?int $quantity = null;

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

    public function getFacility(): ?Facility
    {
        return $this->facility;
    }

    public function setFacility(Facility $facility): self
    {
        $this->facility = $facility;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }
}
