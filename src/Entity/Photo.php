<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'photos')]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['beach'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Beach::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(name: 'beach_id', referencedColumnName: 'id', nullable: false)]
    private ?Beach $beach = null;

    #[ORM\Column(type: 'string', length: 2048, nullable: true)]
    #[Groups(['beach'])]
    private ?string $url = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['beach'])]
    private ?string $storageType = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['beach'])]
    private ?string $base64Data = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Groups(['beach'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['beach'])]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    // Getters e Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeach(): ?Beach
    {
        return $this->beach;
    }

    public function setBeach(?Beach $beach): self
    {
        $this->beach = $beach;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getStorageType(): ?string
    {
        return $this->storageType;
    }

    public function setStorageType(?string $storageType): self
    {
        $this->storageType = $storageType;
        return $this;
    }

    public function getBase64Data(): ?string
    {
        return $this->base64Data;
    }

    public function setBase64Data(?string $base64Data): self
    {
        $this->base64Data = $base64Data;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
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
}
