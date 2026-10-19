<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Sponsor;
use App\Entity\TeamMember;
use App\Enum\EventType;
use App\Enum\SponsorTier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Données d'exemple pour l'ébauche du site : à remplacer par le vrai contenu.
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadEvents($manager);
        $this->loadSponsors($manager);
        $this->loadTeam($manager);

        $manager->flush();
    }

    private function loadEvents(ObjectManager $manager): void
    {
        $today = new \DateTimeImmutable('today 18:00');

        $events = [
            ['Meetup Symfony Montréal #1 — Lancement de Symfony Québec', 'meetup-montreal-1', EventType::Meetup, '-60 days', 'Montréal', 'Soirée de lancement de la communauté : présentation du projet Symfony Québec, deux présentations éclair et réseautage.'],
            ['Atelier : migrer vers Symfony 8', 'atelier-migrer-symfony-8', EventType::Workshop, '-20 days', 'Québec', 'Atelier pratique de 3 heures pour mettre à niveau une application Symfony 6.4/7.4 vers Symfony 8.'],
            ['Meetup Symfony Québec #2', 'meetup-quebec-2', EventType::Meetup, '+14 days', 'Québec', 'Deux conférences de 30 minutes suivies d\'un 5 à 7. Thèmes : AssetMapper sans Node, et Symfony Messenger en production.'],
            ['Cercle de professionnels — Architecture et qualité', 'cercle-pro-architecture', EventType::ProCircle, '+30 days', 'En ligne', 'Rencontre mensuelle du cercle : retours d\'expérience, revue d\'architecture et entraide entre leads et CTO.'],
            ['Conférence Symfony Québec 2027', 'conference-2027', EventType::Conference, '+150 days', 'Montréal', 'Une journée de conférences francophones et anglophones autour de l\'écosystème Symfony et PHP.'],
        ];

        foreach ($events as [$title, $slug, $type, $offset, $city, $description]) {
            $event = (new Event())
                ->setTitle($title)
                ->setSlug($slug)
                ->setType($type)
                ->setStartsAt($today->modify($offset))
                ->setCity($city)
                ->setDescription($description)
                ->setOnline('En ligne' === $city);
            if (!$event->isOnline()) {
                $event->setVenue('Lieu à confirmer');
            }
            $manager->persist($event);
        }
    }

    private function loadSponsors(ObjectManager $manager): void
    {
        $sponsors = [
            ['Commanditaire Platine (exemple)', SponsorTier::Platinum, 'https://example.com'],
            ['Commanditaire Or (exemple)', SponsorTier::Gold, 'https://example.com'],
            ['Commanditaire Argent (exemple)', SponsorTier::Silver, 'https://example.com'],
            ['Symfony', SponsorTier::Community, 'https://symfony.com'],
        ];

        foreach ($sponsors as $position => [$name, $tier, $url]) {
            $sponsor = (new Sponsor())
                ->setName($name)
                ->setTier($tier)
                ->setWebsiteUrl($url)
                ->setPosition($position)
                ->setDescription('Description du commanditaire à compléter.');
            $manager->persist($sponsor);
        }
    }

    private function loadTeam(ObjectManager $manager): void
    {
        $members = [
            ['Prénom Nom', 'Fondateur·rice et coordination', true],
            ['Prénom Nom', 'Responsable des événements', false],
            ['Prénom Nom', 'Responsable des commandites', false],
            ['Prénom Nom', 'Conférencier·ère et cercle de professionnels', true],
        ];

        foreach ($members as $position => [$name, $role, $speaker]) {
            $member = (new TeamMember())
                ->setName($name)
                ->setRole($role)
                ->setBio('Courte biographie à compléter : parcours, expertise Symfony, sujets de prédilection.')
                ->setSpeaker($speaker)
                ->setPosition($position)
                ->setLinkedinUrl('https://www.linkedin.com/');
            $manager->persist($member);
        }
    }
}
