<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Sponsor;
use App\Entity\TeamMember;
use App\Repository\EventRepository;
use App\Repository\SponsorRepository;
use App\Repository\TeamMemberRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\ColorScheme;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
#[IsGranted('ROLE_ADMIN')]
final class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly EventRepository $events,
        private readonly SponsorRepository $sponsors,
        private readonly TeamMemberRepository $members,
    ) {
    }

    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'upcoming_events' => $this->events->findUpcoming(new \DateTimeImmutable(), 5),
            'sponsor_count' => $this->sponsors->count(),
            'member_count' => $this->members->count(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony <strong>Québec</strong> · Admin')
            ->setFaviconPath('favicon.svg')
            ->setLocales(['fr'])
            ->setDefaultColorScheme(ColorScheme::DARK);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::section('Contenu');
        yield MenuItem::linkTo(EventCrudController::class, 'Événements', 'fa fa-calendar');
        yield MenuItem::linkTo(SponsorCrudController::class, 'Commanditaires', 'fa fa-handshake');
        yield MenuItem::linkTo(TeamMemberCrudController::class, 'Équipe', 'fa fa-users');
        yield MenuItem::section();
        yield MenuItem::linkToUrl('Voir le site', 'fa fa-arrow-up-right-from-square', $this->generateUrl('app_home'))->setLinkTarget('_blank');
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out');
    }
}
