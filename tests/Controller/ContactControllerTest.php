<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ContactControllerTest extends WebTestCase
{
    public function testSubjectCanBePreselectedFromQuery(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact?sujet=conference');

        self::assertCheckboxChecked('contact[subject]', 'conference');
    }

    public function testInvalidSubmissionShowsErrors(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');
        $client->submitForm('Envoyer');

        self::assertResponseStatusCodeSame(422);
        self::assertSelectorExists('.form-errors');
        self::assertEmailCount(0);
    }

    public function testValidSubmissionSendsEmail(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');
        $client->submitForm('Envoyer', [
            'contact[subject]' => 'expertise',
            'contact[name]' => 'Alex Tremblay',
            'contact[email]' => 'alex@example.com',
            'contact[organization]' => 'Acme',
            'contact[message]' => 'Nous aimerions être accompagnés pour migrer notre application vers Symfony 8.',
        ]);

        self::assertResponseRedirects('/contact');
        self::assertEmailCount(1);

        $email = self::getMailerMessage();
        self::assertEmailHeaderSame($email, 'To', 'bonjour@symfony-quebec.ca');
        self::assertEmailTextBodyContains($email, 'Alex Tremblay');

        $client->followRedirect();
        self::assertSelectorTextContains('.flash--success', 'Merci');
    }
}
