<?php

namespace App\Model;

use App\Enum\ContactSubject;
use Symfony\Component\Validator\Constraints as Assert;

final class ContactRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\Length(max: 120)]
    public ?string $organization = null;

    #[Assert\NotNull(message: 'Choisissez un sujet.')]
    public ?ContactSubject $subject = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 20, max: 5000)]
    public ?string $message = null;
}
