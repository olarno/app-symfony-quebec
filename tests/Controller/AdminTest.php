<?php

namespace App\Tests\Controller;

use App\Entity\Event;
use App\Entity\Sponsor;
use App\Entity\TeamMember;
use App\Repository\EventRepository;
use App\Repository\SponsorRepository;
use App\Repository\TeamMemberRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AdminTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testAdminRequiresLogin(): void
    {
        $this->client->request('GET', '/admin');

        self::assertResponseRedirects('/connexion');
    }

    public function testLoginWithValidCredentials(): void
    {
        $this->client->request('GET', '/connexion');
        $this->client->submitForm('Se connecter', ['_username' => 'admin', '_password' => 'admin']);

        self::assertResponseRedirects('/admin');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('body', 'Prochains événements');
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $this->client->request('GET', '/connexion');
        $this->client->submitForm('Se connecter', ['_username' => 'admin', '_password' => 'mauvais']);

        self::assertResponseRedirects('/connexion');
        $this->client->followRedirect();
        self::assertSelectorExists('.alert-danger');
    }

    public function testCreateAndEditEvent(): void
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/evenements/new');
        self::assertResponseIsSuccessful();
        $this->client->submitForm('Créer', [
            'Event[title]' => 'Meetup test',
            'Event[slug]' => 'meetup-test',
            'Event[type]' => 'meetup',
            'Event[startsAt]' => '2030-01-15T18:00',
            'Event[city]' => 'Sherbrooke',
            'Event[description]' => 'Un meetup créé depuis le back-office.',
        ]);
        self::assertResponseRedirects();

        $event = $this->events()->findOneBy(['slug' => 'meetup-test']);
        self::assertInstanceOf(Event::class, $event);

        $this->client->request('GET', sprintf('/admin/evenements/%d/edit', $event->getId()));
        $this->client->submitForm('Sauvegarder les modifications', ['Event[city]' => 'Gatineau']);
        self::assertResponseRedirects();

        self::getContainer()->get('doctrine')->getManager()->clear();
        self::assertSame('Gatineau', $this->events()->find($event->getId())?->getCity());

        $this->client->request('GET', '/evenements/meetup-test');
        self::assertSelectorTextContains('h1', 'Meetup test');
    }

    public function testCreateAndDeleteSponsor(): void
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/commanditaires/new');
        $this->client->submitForm('Créer', [
            'Sponsor[name]' => 'Acme Québec',
            'Sponsor[tier]' => 'gold',
            'Sponsor[websiteUrl]' => 'https://acme.example.com',
        ]);
        self::assertResponseRedirects();

        $sponsor = $this->sponsors()->findOneBy(['name' => 'Acme Québec']);
        self::assertInstanceOf(Sponsor::class, $sponsor);

        $this->client->request('GET', '/commanditaires');
        self::assertSelectorTextContains('.sponsor-tier--gold', 'Acme Québec');

        $this->deleteFromIndex('/admin/commanditaires', $sponsor->getId());
        self::assertNull($this->sponsors()->find($sponsor->getId()));
    }

    public function testCreateAndDeleteTeamMember(): void
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/equipe/new');
        $this->client->submitForm('Créer', [
            'TeamMember[name]' => 'Camille Gagnon',
            'TeamMember[role]' => 'Bénévole',
            'TeamMember[bio]' => 'Développeuse Symfony à Québec.',
        ]);
        self::assertResponseRedirects();

        $member = $this->members()->findOneBy(['name' => 'Camille Gagnon']);
        self::assertInstanceOf(TeamMember::class, $member);

        $this->deleteFromIndex('/admin/equipe', $member->getId());
        self::assertNull($this->members()->find($member->getId()));
    }

    private function loginAsAdmin(): void
    {
        $provider = self::getContainer()->get('security.user.provider.concrete.admin_users');
        $this->client->loginUser($provider->loadUserByIdentifier('admin'));
    }

    /**
     * Supprime comme le fait l'interface : POST avec le jeton CSRF du formulaire caché de la liste.
     */
    private function deleteFromIndex(string $indexUrl, int $id): void
    {
        $crawler = $this->client->request('GET', $indexUrl);
        $token = $crawler->filter('#action-confirmation-form input[name="token"]')->attr('value');

        $this->client->request('POST', sprintf('%s/%d/delete', $indexUrl, $id), ['token' => $token]);

        self::assertResponseRedirects();
        self::getContainer()->get('doctrine')->getManager()->clear();
    }

    private function events(): EventRepository
    {
        return self::getContainer()->get(EventRepository::class);
    }

    private function sponsors(): SponsorRepository
    {
        return self::getContainer()->get(SponsorRepository::class);
    }

    private function members(): TeamMemberRepository
    {
        return self::getContainer()->get(TeamMemberRepository::class);
    }
}
