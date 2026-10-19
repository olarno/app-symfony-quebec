<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppsController extends AbstractController
{
    #[Route('/applications', name: 'app_apps_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('apps/index.html.twig');
    }
}
