<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'beach')]
class Beach
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $geoCoordinates = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $images = null;

    // Getters and setters
    // public function getId(): ?int
    // {
    //     return $id;
    // }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getGeoCoordinates(): ?array
    {
        return $this->geoCoordinates;
    }

    public function setGeoCoordinates(?array $geoCoordinates): void
    {
        $this->geoCoordinates = $geoCoordinates;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): void
    {
        $this->observation = $observation;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): void
    {
        $this->images = $images;
    }

    public function __toString(): string
    {
        return sprintf(
            'Beach{id=%d, name="%s", address="%s", geoCoordinates="%s", description="%s", observation="%s", images="%s"}',
            $this->id,
            $this->name,
            $this->address,
            json_encode($this->geoCoordinates),
            $this->description,
            $this->observation,
            $this->images
        );
    }
}
