<?php

namespace App\Enum;

enum ContactSubject: string
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
}
