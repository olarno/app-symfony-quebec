<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum EventType: string implements TranslatableInterface
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

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->label(), locale: $locale);
    }
}
