<?php

namespace App\Entity;

use App\Enum\SponsorTier;
use App\Repository\SponsorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: SponsorTier::class)]
    #[Assert\NotNull]
    private ?SponsorTier $tier = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Url(requireTld: true)]
    private ?string $websiteUrl = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /** Nom du fichier logo, dans public/uploads/sponsors/. */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column]
    private int $position = 0;

    public function __toString(): string
    {
        return (string) $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTier(): ?SponsorTier
    {
        return $this->tier;
    }

    public function setTier(?SponsorTier $tier): static
    {
        $this->tier = $tier;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): static
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
