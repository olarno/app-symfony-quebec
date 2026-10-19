<?php

namespace App\Controller;

use App\Enum\SponsorTier;
use App\Repository\SponsorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SponsorController extends AbstractController
{
    #[Route('/commanditaires', name: 'app_sponsor_index', methods: ['GET'])]
    public function index(SponsorRepository $sponsors): Response
    {
        return $this->render('sponsor/index.html.twig', [
            'sponsor_groups' => $sponsors->findGroupedByTier(),
            'tiers' => SponsorTier::cases(),
        ]);
    }
}
