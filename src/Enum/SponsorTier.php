<?php

namespace App\Enum;

enum SponsorTier: string
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
}
