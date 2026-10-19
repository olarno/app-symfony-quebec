<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/evenements')]
final class EventController extends AbstractController
{
    #[Route('', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $events): Response
    {
        $now = new \DateTimeImmutable();

        return $this->render('event/index.html.twig', [
            'upcoming_events' => $events->findUpcoming($now),
            'past_events' => $events->findPast($now),
        ]);
    }

    #[Route('/{slug}', name: 'app_event_show', methods: ['GET'])]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
}
