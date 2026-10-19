<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
            'page_title' => 'Symfony <strong>Québec</strong> · Admin',
            'favicon_path' => 'favicon.svg',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('admin'),
            'username_label' => "Nom d'utilisateur",
            'password_label' => 'Mot de passe',
            'sign_in_label' => 'Se connecter',
        ]);
    }

    #[Route('/deconnexion', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \LogicException('Intercepté par le pare-feu (logout).');
    }
}
