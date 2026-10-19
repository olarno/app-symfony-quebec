<?php

namespace App\Entity;

use App\Repository\TeamMemberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamMemberRepository::class)]
class TeamMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $role = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $bio = null;

    /** Nom du fichier photo, dans public/uploads/team/. */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(requireTld: true)]
    private ?string $linkedinUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(requireTld: true)]
    private ?string $githubUrl = null;

    /** Membre disponible comme conférencier. */
    #[ORM\Column]
    private bool $speaker = false;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLinkedinUrl(): ?string
    {
        return $this->linkedinUrl;
    }

    public function setLinkedinUrl(?string $linkedinUrl): static
    {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    public function getGithubUrl(): ?string
    {
        return $this->githubUrl;
    }

    public function setGithubUrl(?string $githubUrl): static
    {
        $this->githubUrl = $githubUrl;

        return $this;
    }

    public function isSpeaker(): bool
    {
        return $this->speaker;
    }

    public function setSpeaker(bool $speaker): static
    {
        $this->speaker = $speaker;

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

    public function getInitials(): string
    {
        $initials = '';
        foreach (preg_split('/[\s-]+/', (string) $this->name, -1, \PREG_SPLIT_NO_EMPTY) as $part) {
            $initials .= mb_strtoupper(mb_substr($part, 0, 1));
        }

        return mb_substr($initials, 0, 2);
    }
}
