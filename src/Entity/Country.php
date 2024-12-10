<?php

namespace App\Entity;

use App\Enum\ContinentEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'countries')]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    #[Groups(['country'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['country'])]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['country'])]
    private ?string $isoCode = null;

    #[ORM\Column(type: 'string', enumType: ContinentEnum::class)]
    #[Groups(['country'])]
    private ?ContinentEnum $continent = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsoCode(): ?string
    {
        return $this->isoCode;
    }

    public function setIsoCode(?string $isoCode): self
    {
        $this->isoCode = $isoCode;
        return $this;
    }

    public function getContinent(): ?ContinentEnum
    {
        return $this->continent;
    }

    public function setContinent(ContinentEnum $continent): self
    {
        $this->continent = $continent;
        return $this;
    }
}