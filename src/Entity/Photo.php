<?php

namespace App\Entity;

use App\Enum\PhotoStorageTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'photos')]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['photo'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Beach::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(name: 'beach_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['photo'])]
    private ?Beach $beach = null;

    #[ORM\Column(type: 'string', length: 2048, nullable: true)]
    #[Groups(['photo'])]
    private ?string $url = null;

    #[ORM\Column(type: 'string', enumType: PhotoStorageTypeEnum::class)]
    #[Groups(['photo'])]
    private ?PhotoStorageTypeEnum $storageType = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['photo'])]
    private ?string $base64Data = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Groups(['photo'])]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['photo'])]
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

    public function getStorageType(): ?PhotoStorageTypeEnum
    {
        return $this->storageType;
    }

    public function setStorageType(PhotoStorageTypeEnum $storageType): self
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
