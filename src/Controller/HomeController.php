<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\SponsorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(EventRepository $events, SponsorRepository $sponsors): Response
    {
        $now = new \DateTimeImmutable();

        return $this->render('home/index.html.twig', [
            'upcoming_events' => $events->findUpcoming($now, 3),
            'past_events' => $events->findPast($now, 3),
            'sponsor_groups' => $sponsors->findGroupedByTier(),
        ]);
    }
}
