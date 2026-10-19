<?php

namespace App\Repository;

use App\Entity\Sponsor;
use App\Enum\SponsorTier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sponsor>
 */
class SponsorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sponsor::class);
    }

    /**
     * Commanditaires groupés par palier, dans l'ordre des paliers (Platine en premier).
     *
     * @return array<string, array{tier: SponsorTier, sponsors: list<Sponsor>}>
     */
    public function findGroupedByTier(): array
    {
        $grouped = [];
        foreach (SponsorTier::cases() as $tier) {
            $grouped[$tier->value] = ['tier' => $tier, 'sponsors' => []];
        }

        foreach ($this->findBy([], ['position' => 'ASC', 'name' => 'ASC']) as $sponsor) {
            $grouped[$sponsor->getTier()->value]['sponsors'][] = $sponsor;
        }

        return array_filter($grouped, static fn (array $group): bool => [] !== $group['sponsors']);
    }
}
