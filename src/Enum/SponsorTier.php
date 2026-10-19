<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum SponsorTier: string implements TranslatableInterface
{
    case Platinum = 'platinum';
    case Gold = 'gold';
    case Silver = 'silver';
    case Community = 'community';

    public function label(): string
    {
        return match ($this) {
            self::Platinum => 'Platine',
            self::Gold => 'Or',
            self::Silver => 'Argent',
            self::Community => 'Partenaire communautaire',
        };
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->label(), locale: $locale);
    }
}
