<?php

namespace App\Controller;

use App\Repository\TeamMemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TeamController extends AbstractController
{
    #[Route('/equipe', name: 'app_team_index', methods: ['GET'])]
    public function index(TeamMemberRepository $members): Response
    {
        return $this->render('team/index.html.twig', [
            'members' => $members->findAllOrdered(),
        ]);
    }
}
