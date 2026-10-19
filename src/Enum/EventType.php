<?php

namespace App\Enum;

enum EventType: string
{
    case Meetup = 'meetup';
    case Conference = 'conference';
    case Workshop = 'workshop';
    case ProCircle = 'pro_circle';

    public function label(): string
    {
        return match ($this) {
            self::Meetup => 'Meetup',
            self::Conference => 'Conférence',
            self::Workshop => 'Atelier',
            self::ProCircle => 'Cercle de professionnels',
        };
    }
}
