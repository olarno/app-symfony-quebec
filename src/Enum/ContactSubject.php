<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum ContactSubject: string implements TranslatableInterface
{
    case Conference = 'conference';
    case Expertise = 'expertise';
    case Event = 'evenement';
    case Sponsorship = 'commandite';
    case Other = 'autre';

    public function label(): string
    {
        return match ($this) {
            self::Conference => 'Conférence — inviter un de nos conférenciers ou proposer une présentation',
            self::Expertise => 'Expertise — accompagnement par le cercle de professionnels',
            self::Event => 'Événement — organiser ou accueillir un meetup',
            self::Sponsorship => 'Commandite — devenir commanditaire',
            self::Other => 'Autre',
        };
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->label(), locale: $locale);
    }
}
