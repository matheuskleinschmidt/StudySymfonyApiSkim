<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'beaches')]
class Beach
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['beach'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['beach'])]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(name: 'city_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['beach'])]
    private ?City $city = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['beach'])]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['beach'])]
    private ?string $postalCode = null;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(['beach'])]
    private ?array $geoCoordinates = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['beach'])]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['beach'])]
    private ?string $status = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['beach'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['beach'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['beach'])]
    private ?string $observation = null;

    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'beach', cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'EAGER')]
    #[Groups(['beach'])]
    private Collection $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }
   
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getGeoCoordinates(): ?array
    {
        return $this->geoCoordinates;
    }

    public function setGeoCoordinates(?array $geoCoordinates): self
    {
        $this->geoCoordinates = $geoCoordinates;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
   
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
   
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
   
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
   
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
   
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;
        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setBeach($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            if ($photo->getBeach() === $this) {
                $photo->setBeach(null);
            }
        }

        return $this;
    }
}
