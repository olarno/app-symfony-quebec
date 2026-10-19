<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PagesTest extends WebTestCase
{
    /**
     * @return iterable<string, array{string, string}>
     */
    public static function pages(): iterable
    {
        yield 'accueil' => ['/', 'Faire grandir Symfony'];
        yield 'événements' => ['/evenements', 'Événements'];
        yield 'détail événement' => ['/evenements/meetup-quebec-2', 'Meetup Symfony Québec #2'];
        yield 'commanditaires' => ['/commanditaires', 'Nos commanditaires'];
        yield 'équipe' => ['/equipe', "L'équipe"];
        yield 'applications' => ['/applications', 'Nos applications'];
        yield 'contact' => ['/contact', 'Contact'];
    }

    #[DataProvider('pages')]
    public function testPageIsSuccessful(string $url, string $title): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', $title);
    }

    public function testHomeListsUpcomingAndPastEvents(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertSelectorExists('.event-card:not(.event-card--past)');
        self::assertSelectorExists('.event-card--past');
        self::assertSelectorExists('a[href="https://carte.symfony-quebec.ca"]');
        self::assertGreaterThan(0, $crawler->filter('.sponsor-logos li')->count());
    }

    public function testUnknownEventReturns404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/evenements/inexistant');

        self::assertResponseStatusCodeSame(404);
    }
}
